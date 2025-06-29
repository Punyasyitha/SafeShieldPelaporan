<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubMateriController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'submateri',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.submateri.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/submateri'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDSUBMATERI'] ?? 0) // urutkan berdasarkan numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.submateri.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/submateri'),
        ]);
        //dd($data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];

        // Ambil data materi dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'materi',
            'data'  => '*',
            'limit' => 100,
        ]);

        // Cek apakah response berhasil
        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data materi');
        }

        $result = $response->json();
        $materi = collect($result['data'] ?? []); // handle jika data kosong

        return view('admin.submateri.add', [
            'authorize' => $authorize,
            'url'       => 'admin/submateri',
            'materi'   => $materi,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'materiid'      => 'required|exists:materi,idmateri',
            'judul_submateri'  => 'required|string|max:255',
            'isi'              => 'required|string',
        ]);

        try {
            $lastId = DB::table('submateri')->max('idsubmateri') ?? 0;
            $newId = $lastId + 1;

            $payload = [
                'table' => 'submateri',
                'data'  => [
                    [
                        'materiid'        => $request->materiid,
                        'judul_submateri' => $request->judul_submateri,
                        'isi'             => $request->isi,
                        'created_at'      => now()->format('d-M-y h.i.s A'), // contoh format Oracle
                        'updated_at'      => now()->format('d-M-y h.i.s A'),
                    ]
                ]
            ];

            // Kirim ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idsubmateri = decrypt($id);
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'submateri',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDSUBMATERI' => $idsubmateri
                ],
                'limit' => 1 // hanya ambil 1 baris (karena idsubmateri unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $sbmtr = (object) $result['data'][0];

            return view('admin.submateri.show', [
                'sbmtr' => $sbmtr,
                'url' => 'admin/submateri',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idsubmateri = decrypt($id); // Jika ID tidak dienkripsi, langsung pakai $id

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'submateri',
                'data'   => '*',
                'filter' => [
                    'IDSUBMATERI' => $idsubmateri
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $sbmtr = (object) $result['data'][0];

            // Ambil data penulis
            $responseMateri = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'materi',
                'data'  => '*',
                'limit' => 100,
            ]);

            $materi = collect($responseMateri['data'] ?? [])->map(function ($item) {
                return (object) $item;
            });

            return view('admin.submateri.edit', [
                'sbmtr'     => $sbmtr,
                'materi' => $materi,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materiid'         => 'required|exists:materi,idmateri',
            'judul_submateri'  => 'required|string|max:255',
            'isi'              => 'required|string',
        ]);

        try {
            $idsubmateri = decrypt($id);

            $payload = [
                'table'      => 'submateri',
                'data'       => [
                    'MATERIID'        => $request->materiid,
                    'JUDUL_SUBMATERI' => $request->judul_submateri,
                    'ISI'             => $request->isi,
                    'UPDATED_AT'      => now()->format('d-M-y h.i.s A'),
                ],
                'conditions' => [
                    'IDSUBMATERI' => $idsubmateri
                ],
                'operators'  => [""]
            ];
            // dd($payload);
            // Kirim ke API eksternal (update)
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Gagal memperbarui data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            $idsubmateri= decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Submateri tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'submateri',
                'conditions' => [
                    'IDSUBMATERI' => $idsubmateri
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.submateri.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
