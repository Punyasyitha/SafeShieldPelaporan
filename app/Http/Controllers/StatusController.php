<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.master.status.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/master/status'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDSTATUS'] ?? 0) // urutkan berdasarkan IDstatus numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.master.status.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/status'),
        ]);
        //dd($data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.status.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/status'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idstatus' => 'nullable',
            'nama_status' => 'required|string|max:255',
        ]);

        try {
            // Generate ID sts_pengaduan terbaru (ambil dari API atau lokal DB)
            $lastId = DB::table('mst_sts_pengaduan')->max('idstatus') ?? 0;
            $newId = $lastId + 1;

            // Buat payload untuk dikirim ke API
            $payload = [
                'table' => 'mst_sts_pengaduan',
                'data'  => [
                    [
                        'nama_status' => $request->nama_status,
                    ]
                ]
            ];

            // Kirim POST request ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);

            // Jika gagal
            if (!$response->successful()) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            // Cek isi respons jika status gagal
            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            // Jika berhasil
            return redirect()->route('admin.master.status.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idstatus = decrypt($id);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_sts_pengaduan',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDSTATUS' => $idstatus
                ],
                'limit' => 1 // hanya ambil 1 baris (karena IDstatus unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $sts = (object) $result['data'][0];

            return view('admin.master.status.show', [
                'sts' => $sts,
                'url' => 'admin/master/status',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idstatus = decrypt($id);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_sts_pengaduan',
                'data'   => '*',
                'filter' => [
                    'IDSTATUS' => $idstatus
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $sts = (object) $result['data'][0];

            return view('admin.master.status.edit', [
                'sts' => $sts,
                'url' => 'admin/master/status',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255',
        ]);

        try {
            // Decrypt ID dari parameter
            $idstatus = decrypt($id);

            // Buat payload untuk dikirim ke API
            $payload = [
                'table' => 'mst_sts_pengaduan',
                'data'  => [
                    'NAMA_STATUS' => $request->nama_status,
                ],
                'conditions' => [
                    'IDSTATUS' => $idstatus
                ],
                'operators' => [""]
            ];

            // Kirim POST request ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            // Jika gagal koneksi API
            if (!$response->successful()) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            // Cek isi respons jika status gagal
            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            // Jika berhasil
            return redirect()->route('admin.master.status.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idstatus = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'status tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'mst_sts_pengaduan',
                'conditions' => [
                    'IDSTATUS' => $idstatus
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.status.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
