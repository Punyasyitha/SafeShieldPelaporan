<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenulisController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_penulis',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.master.penulis.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/master/penulis'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDPENULIS'] ?? 0) // urutkan berdasarkan IDpenulis numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.master.penulis.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/penulis'),
        ]);
        //dd($data);
    }

    public function add()
    {
        return view('admin.master.penulis.add', [
            'authorize' => (object)['add' => '1'],
            'url' => 'admin/master/penulis'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpenulis' => 'nullable',
            'nama_penulis' => 'required|string|max:100',
        ]);

        try {
            // Generate ID penulis terbaru (ambil dari API atau lokal DB)
            $lastId = DB::table('mst_penulis')->max('idpenulis') ?? 0;
            $newId = $lastId + 1;

            // Buat payload untuk dikirim ke API
            $payload = [
                'table' => 'mst_penulis',
                'data'  => [
                    [
                        'nama_penulis' => $request->nama_penulis,
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
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            // Cek isi respons jika status gagal
            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            // Jika berhasil
            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idpenulis = decrypt($id);
            // dd(['idpenulis' => decrypt($id)]);
            // Request ke API dengan filter berdasarkan IDpenulis
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_penulis',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDPENULIS' => $idpenulis
                ],
                'limit' => 1 // hanya ambil 1 baris (karena IDpenulis unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $pns = (object) $result['data'][0];

            return view('admin.master.penulis.show', [
                'pns' => $pns,
                'url' => 'admin/master/penulis',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idpenulis = decrypt($id);
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'mst_penulis',
                'data'   => '*',
                'filter' => [
                    'IDPENULIS' => $idpenulis
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $pns = (object) $result['data'][0];

            return view('admin.master.penulis.edit', [
                'pns' => $pns,
                'url' => 'admin/master/penulis',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penulis' => 'required|string|max:100',
        ]);
        try {
            // Decrypt ID dari parameter
            $idpenulis = decrypt($id);

            // Payload untuk API update
            $payload = [
                'table' => 'mst_penulis',
                'data' => [
                    'NAMA_PENULIS' => $request->nama_penulis,
                    'UPDATED_AT' => now()->format('d-M-y h.i.s A'), // format waktu ke Oracle
                ],
                'conditions' => [
                    'IDPENULIS' => $idpenulis
                ],
                'operators' => [""] // hanya 1 kondisi, jadi operator dikosongkan
            ];

            // Kirim ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {

            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idpenulis = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'mst_penulis',
                'conditions' => [
                    'IDPENULIS' => $idpenulis
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
