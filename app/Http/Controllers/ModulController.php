<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_modul',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.master.modul.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/master/modul'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDMODUL'] ?? 0) // urutkan berdasarkan numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.master.modul.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/modul'),
        ]);
        //dd($data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.modul.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/modul'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idmodul' => 'nullable',
            'nama_modul'   => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_terbit' => 'required|date',
        ]);

        try {
            // Generate ID modul terbaru (ambil dari API atau lokal DB)
            $lastId = DB::table('mst_modul')->max('idmodul') ?? 0;
            $newId = $lastId + 1;

            // Buat payload untuk dikirim ke API
            $payload = [
                'table' => 'mst_modul',
                'data'  => [
                    [
                        'nama_modul' => $request->nama_modul,
                        'deskripsi'    => $request->deskripsi,
                        'tahun_terbit' => [
                            'type' => 'date',
                            'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tahun_terbit)->format('d-m-Y')
                        ],
                        'created_at'    => now()->format('d-M-y h.i.s A'), // contoh format Oracle
                        'updated_at'    => now()->format('d-M-y h.i.s A'),
                    ]
                ]
            ];
            //dd($payload);
            // Kirim POST request ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);

            // Jika gagal
            if (!$response->successful()) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            // Cek isi respons jika status gagal
            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            // Jika berhasil
            return redirect()->route('admin.master.modul.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            // 🔓 Dekripsi ID
            $idmodul = decrypt($id);
            // dd(['idmodul' => decrypt($id)]);

            // Request ke API dengan filter
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_modul',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDMODUL' => $idmodul
                ],
                'limit' => 1 // hanya ambil 1 baris (karena IDmodul unik)
            ]);
            if (!$response->successful()) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $mod = (object) $result['data'][0];

            return view('admin.master.modul.show', [
                'mod' => $mod,
                'url' => 'admin/master/modul',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idmodul = decrypt($id);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_modul',
                'data'   => '*',
                'filter' => [
                    'IDMODUL' => $idmodul
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $mod = (object) $result['data'][0];

            return view('admin.master.modul.edit', [
                'mod' => $mod,
                'url' => 'admin/master/modul',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $request->validate([
            'nama_modul'   => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_terbit' => 'required| date',
        ]);

        try {
            $idmodul = decrypt($id);

            // Payload untuk API update
            $payload = [
                'table' => 'mst_modul',
                'data' => [
                    'NAMA_MODUL' => $request->nama_modul,
                    'DESKRIPSI'    => $request->deskripsi,
                    'TAHUN_TERBIT' => [
                        'type' => 'date',
                        'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tahun_terbit)->format('d-m-Y')
                    ],
                    'UPDATED_AT' => now()->format('d-M-y h.i.s A'), // format waktu ke Oracle
                ],
                'conditions' => [
                    'IDMODUL' => $idmodul
                ],
                'operators' => [""] // hanya 1 kondisi, jadi operator dikosongkan
            ];
            // Kirim ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.modul.list')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {

            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idmodul = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'mst_modul',
                'conditions' => [
                    'IDMODUL' => $idmodul
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.modul.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}