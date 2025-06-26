<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_kategori',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.master.kategori.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/master/kategori'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDKATEGORI'] ?? 0) // urutkan berdasarkan IDKATEGORI numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.master.kategori.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/kategori'),
        ]);
        //dd($data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.kategori.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/kategori'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idkategori' => 'nullable',
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            // Generate ID kategori terbaru (ambil dari API atau lokal DB)
            $lastId = DB::table('mst_kategori')->max('idkategori') ?? 0;
            $newId = $lastId + 1;

            // Buat payload untuk dikirim ke API
            $payload = [
                'table' => 'mst_kategori',
                'data'  => [
                    [
                        'nama_kategori' => $request->nama_kategori,
                        'created_at'    => now()->format('d-M-y h.i.s A'), // contoh format Oracle
                        'updated_at'    => now()->format('d-M-y h.i.s A'),
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
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            // Cek isi respons jika status gagal
            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            // Jika berhasil
            return redirect()->route('admin.master.kategori.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            // Decrypt IDKATEGORI dari parameter
            $idkategori = decrypt($id);
            // dd(['idkategori' => decrypt($id)]);

            // Request ke API dengan filter berdasarkan IDKATEGORI
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_kategori',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDKATEGORI' => $idkategori
                ],
                'limit' => 1 // hanya ambil 1 baris (karena IDKATEGORI unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $ktg = (object) $result['data'][0];

            return view('admin.master.kategori.show', [
                'ktg' => $ktg,
                'url' => 'admin/master/kategori',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            // Decrypt IDKATEGORI dari parameter
            $idkategori = decrypt($id);

            // Request ke API dengan filter berdasarkan IDKATEGORI
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_kategori',
                'data'   => '*',
                'filter' => [
                    'IDKATEGORI' => $idkategori
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $ktg = (object) $result['data'][0];

            return view('admin.master.kategori.edit', [
                'ktg' => $ktg,
                'url' => 'admin/master/kategori',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            // Decrypt ID dari parameter
            $idkategori = decrypt($id);

            // Payload untuk API update
            $payload = [
                'table' => 'mst_kategori',
                'data' => [
                    'NAMA_KATEGORI' => $request->nama_kategori,
                    'UPDATED_AT' => now()->format('d-M-y h.i.s A'), // format waktu ke Oracle
                ],
                'conditions' => [
                    'IDKATEGORI' => $idkategori
                ],
                'operators' => [""] // hanya 1 kondisi, jadi operator dikosongkan
            ];

            // Kirim ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.kategori.list')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {

            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Dekripsi ID
            $idkategori = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'mst_kategori',
                'conditions' => [
                    'IDKATEGORI' => $idkategori
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.kategori.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}