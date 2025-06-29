<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FormPengaduanController extends Controller
{
    function add()
    {
        return view('user.pengaduan.add');
    }

    public function index()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // Ambil data pengaduan milik user ini saja
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table'  => 'pengaduan',
            'data'   => '*',
            'filter' => ['USERID' => $userId], // ✅ Filter berdasarkan user login
            'limit'  => 100,
        ]);

        // Ambil referensi status pengaduan
        $responseStatus = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
        ]);

        $statusList = collect($responseStatus['data'] ?? []);
        $statusMap = $statusList->pluck('NAMA_STATUS', 'IDSTATUS'); // mapping idstatus => nama_status

        if (!$response->successful()) {
            return view('user.pengaduan.list', [
                'list' => collect(),
                'authorize' => (object)['add' => '1'],
                'url' => url('user/pengaduan'),
                'warnaStatus' => [
                    'Verifikasi' => 'bg-red-200 text-red-800',
                    'Panggilan'  => 'bg-orange-200 text-orange-800',
                    'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
                    'Final'      => 'bg-blue-200 text-blue-800',
                    'Selesai'    => 'bg-green-200 text-green-800',
                ],
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        // Proses dan tambahkan NAMA_STATUS
        $data = collect($response->json()['data'] ?? [])
            ->map(function ($item) use ($statusMap) {
                $item = (array) $item;
                $item['NAMA_STATUS'] = $statusMap[$item['STATUSID']] ?? '-';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDPENGADUAN'] ?? 0)
            ->values();

        return view('user.pengaduan.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('user/pengaduan'),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan'  => 'bg-orange-200 text-orange-800',
                'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
                'Final'      => 'bg-blue-200 text-blue-800',
                'Selesai'    => 'bg-green-200 text-green-800',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengadu'         => 'required|string|max:100',
            'no_telepon'           => 'required|string|max:20',
            'email'                => 'nullable|email',
            'nama_terlapor'        => 'required|string|max:100',
            'tmp_kejadian'         => 'required|string|max:300',
            'tanggal_kejadian'     => 'required|date',
            'detail'               => 'required|string',
            'bukti'                => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mp3,wav|max:5120',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        try {
            $buktiPath = null;

            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $originalName = $file->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $file->storeAs('bukti_pengaduan', $timestampedName, 'public');
                $buktiPath = 'bukti_pengaduan/' . $timestampedName;
            }

            $payload = [
                'table' => 'pengaduan',
                'data'  => [
                    [
                        'nama_pengadu'     => $request->nama_pengadu,
                        'no_telepon'       => $request->no_telepon,
                        'email'            => $request->email,
                        'nama_terlapor'    => $request->nama_terlapor,
                        'tmp_kejadian'     => $request->tmp_kejadian,
                        'tanggal_kejadian' => [
                            'type' => 'date',
                            'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tanggal_kejadian)->format('d-m-Y')
                        ],
                        'detail'           => $request->detail,
                        'bukti'            => $buktiPath,
                        'statusid'         => 1,
                        'userid'           => Auth::id(),
                        'created_at'       => now()->format('d-M-y h.i.s A'),
                        'updated_at'       => now()->format('d-M-y h.i.s A'),
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);
            // dd($response->status(), $response->body());

            if (!$response->successful()) {
                return redirect()->back()->withInput()
                    ->with('error', 'API tidak merespon dengan baik. Status: ' . $response->status());
            }

            return redirect()->route('user.pengaduan.add')
                ->with('success', 'Pengaduan berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idpengaduan = decrypt($id); // Kalau tidak terenkripsi, bisa langsung pakai $id

            // Ambil 1 data pengaduan berdasarkan ID
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'pengaduan',
                'data'   => '*',
                'filter' => [
                    'IDPENGADUAN' => $idpengaduan,
                ],
                'limit' => 1,
            ]);

            if (!$response->successful()) {
                return redirect()->route('user.pengaduan.edit')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();
            if (empty($result['data']) || count($result['data']) === 0) {
                return redirect()->route('user.pengaduan.edit')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            // Ambil referensi status
            $responseStatus = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_sts_pengaduan',
                'data'  => '*',
            ]);

            $status = collect($responseStatus['data'] ?? [])->map(fn($item) => (object) $item);
            $statusMap = $status->pluck('NAMA_STATUS', 'IDSTATUS');

            // Mapping warna status
            $warnaStatus = [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan'  => 'bg-orange-200 text-orange-800',
                'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
                'Final'      => 'bg-blue-200 text-blue-800',
                'Selesai'    => 'bg-green-200 text-green-800',
            ];

            // Tambahkan NAMA_STATUS ke data pengaduan
            $pengaduan = (object) array_merge((array) $result['data'][0], [
                'NAMA_STATUS' => $statusMap[$result['data'][0]['STATUSID']] ?? '-'
            ]);

            return view('user.pengaduan.edit', [
                'pengaduan'     => $pengaduan,
                'statusList'    => $status,
                'warnaStatus'   => $warnaStatus,
                'url'           => 'user/pengaduan',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('user.pengaduan.edit')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $idpengaduan = decrypt($id); // pastikan ID terenkripsi saat dikirim dari view

            $request->validate([
                'nama_pengadu'     => 'required|string|max:100',
                'no_telepon'       => 'required|string|max:20',
                'email'            => 'nullable|email',
                'nama_terlapor'    => 'required|string|max:100',
                'tmp_kejadian'     => 'required|string|max:300',
                'tanggal_kejadian' => 'required|date',
                'detail'           => 'required|string',
                'bukti'            => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mp3,wav|max:5120',
            ]);

            $buktiPath = $request->old_bukti ?? null;

            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $originalName = $file->getClientOriginalName();
                $timestampedName = time() . '_' . $originalName;
                $file->storeAs('bukti_pengaduan', $timestampedName, 'public');
                $buktiPath = 'bukti_pengaduan/' . $timestampedName;
            }

            $payload = [
                'table' => 'pengaduan',
                'data'  =>
                [
                    'NAMA_PENGADU'     => $request->nama_pengadu,
                    'NO_TELEPON'       => $request->no_telepon,
                    'EMAIL'            => $request->email,
                    'NAMA_TERLAPOR'    => $request->nama_terlapor,
                    'TMP_KEJADIAN'     => $request->tmp_kejadian,
                    'TANGGAL_KEJADIAN' => [
                        'type'  => 'date',
                        'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tanggal_kejadian)->format('d-m-Y'),
                    ],
                    'DETAIL'      => $request->detail,
                    'BUKTI'       => $buktiPath,
                    'UPDATED_AT'  => now()->format('d-M-y h.i.s A'),
                ],
                'conditions' => [
                    'IDPENGADUAN' => $idpengaduan
                ],
                'operators' => [""]
            ];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);
            // dd($response->status(), $response->body());

            if (!$response->successful()) {
                return redirect()->back()->withInput()
                    ->with('error', 'API gagal: ' . $response->status());
            }

            return redirect()->route('user.pengaduan.list')
                ->with('success', 'Pengaduan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}