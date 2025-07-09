<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        // Ambil data pengaduan
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'pengaduan',
            'data'  => '*',
            'limit' => 100,
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
            return view('admin.pengaduan.list', [
                'list' => collect(),
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/pengaduan'),
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

        // Proses dan tambahkan NAMA_STATUS berdasarkan STATUSID
        $data = collect($response->json()['data'] ?? [])
            ->map(function ($item) use ($statusMap) {
                $item = (array) $item;
                $item['NAMA_STATUS'] = $statusMap[$item['STATUSID']] ?? '-';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDPENGADUAN'] ?? 0)
            ->values();

        return view('admin.pengaduan.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/pengaduan'),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan'  => 'bg-orange-200 text-orange-800',
                'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
                'Final'      => 'bg-blue-200 text-blue-800',
                'Selesai'    => 'bg-green-200 text-green-800',
            ],
        ]);
    }

    public function show($id)
    {
        try {
            $idpengaduan = decrypt($id);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'pengaduan',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDPENGADUAN' => $idpengaduan
                ],
                'limit' => 1 // hanya ambil 1 baris (karena idpengaduan unik)
            ]);

            // Ambil referensi nama status
            $responseStatus = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_sts_pengaduan',
                'data'  => '*',
            ]);

            $statusList = collect($responseStatus['data'] ?? []);
            $statusMap = $statusList->pluck('NAMA_STATUS', 'IDSTATUS');

            $warnaStatus = [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            ];

            if (!$response->successful()) {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }
            // Tambahkan nama_status ke data pengaduan dan pakai sebagai $pengaduan
            $pengaduan = (object) array_merge((array) $result['data'][0], [
                'NAMA_STATUS' => $statusMap[$result['data'][0]['STATUSID']] ?? '-'
            ]);

            return view('admin.pengaduan.show', [
                'pengaduan' => $pengaduan,
                'url' => 'admin/pengaduan',
                'warnaStatus' => $warnaStatus,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')
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
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();
            if (empty($result['data']) || count($result['data']) === 0) {
                return redirect()->route('admin.pengaduan.list')
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

            return view('admin.pengaduan.edit', [
                'pengaduan'     => $pengaduan,
                'statusList'    => $status,
                'warnaStatus'   => $warnaStatus,
                'url'           => 'admin/pengaduan',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'statusid'   => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $idpengaduan = decrypt($id);

            $payload = [
                'table' => 'pengaduan',
                'data' => [
                    'STATUSID'   => $request->statusid,
                    'KETERANGAN' => $request->keterangan,
                    'UPDATED_AT' => now()->format('d-M-y h.i.s A'),
                ],
                'conditions' => [
                    'IDPENGADUAN' => $idpengaduan
                ],
                'operators' => [""]
            ];
            // dd($payload);
            // Kirim update ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.pengaduan.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'pengaduan tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'pengaduan',
                'conditions' => [
                    'IDPENGADUAN' => $idpengaduan
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.pengaduan.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.pengaduan.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
