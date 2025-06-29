<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'materi',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.materi.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/materi'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDMATERI'] ?? 0) // urutkan berdasarkan numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.materi.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/materi'),
        ]);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        // Ambil data modul dari API
        $responseModul = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_modul',
            'data'  => '*',
            'limit' => 100,
        ]);
        // Ambil data kategori dari API
        $responseKategori = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_kategori',
            'data'  => '*',
            'limit' => 100,
        ]);
        // Cek apakah keduanya berhasil
        if (!$responseModul->successful() || !$responseKategori->successful()) {
            return back()->with('error', 'Gagal mengambil data penulis atau kategori');
        }

        // Ambil hasil
        $modul  = collect($responseModul['data'] ?? []);
        $kategori = collect($responseKategori['data'] ?? []);

        return view('admin.materi.add', [
            'authorize' => $authorize,
            'url'       => 'admin/materi',
            'modul'   => $modul,
            'kategori'  => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'modulid'       => 'required|exists:mst_modul,idmodul',
            'kategoriid'    => 'required|exists:mst_kategori,idkategori',
            'judul_materi'  => 'required|string|max:255',
            'sumber'        => 'required|url',
        ]);

        try {
            $lastId = DB::table('materi')->max('idmateri') ?? 0;
            $newId = $lastId + 1;

            $payload = [
                'table' => 'materi',
                'data'  => [
                    [
                        'modulid'     => $request->modulid,
                        'kategoriid' => $request->kategoriid,
                        'judul_materi' => $request->judul_materi,
                        'sumber'        => $request->sumber,
                        'created_at'    => now()->format('d-M-y h.i.s A'), // contoh format Oracle
                        'updated_at'    => now()->format('d-M-y h.i.s A'),
                    ]
                ]
            ];
            // dd($payload);
            // Kirim ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.materi.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idmateri = decrypt($id);
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'materi',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDMATERI' => $idmateri
                ],
                'limit' => 1 // hanya ambil 1 baris (karena idmateri unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $mtr = (object) $result['data'][0];

            return view('admin.materi.show', [
                'mtr' => $mtr,
                'url' => 'admin/materi',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idmateri = decrypt($id); // Jika tidak dienkripsi, gunakan langsung: $id

            // Ambil data 1 materi berdasarkan ID
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'materi',
                'data'   => '*',
                'filter' => [
                    'IDMATERI' => $idmateri
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data'])) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $mtr = (object) $result['data'][0]; // Data materi yang diedit

            // Ambil data referensi modul
            $responseModul = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_modul',
                'data'  => '*',
                'limit' => 100,
            ]);

            $modul = collect($responseModul['data'] ?? [])->map(fn($item) => (object) $item);

            // Ambil data referensi kategori
            $responseKategori = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_kategori',
                'data'  => '*',
                'limit' => 100,
            ]);

            $kategori = collect($responseKategori['data'] ?? [])->map(fn($item) => (object) $item);

            // Kirim semua data ke view
            return view('admin.materi.edit', [
                'mtr'      => $mtr,
                'modul'    => $modul,
                'kategori' => $kategori,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'modulid'       => 'required|exists:mst_modul,idmodul',
            'kategoriid'    => 'required|exists:mst_kategori,idkategori',
            'judul_materi'  => 'required|string|max:255',
            'sumber'        => 'required|url',
        ]);

        try {
            $idmateri = decrypt($id); // Jika ID dienkripsi, jika tidak, langsung pakai $id

            $payload = [
                'table' => 'materi',
                'data'  => [
                    'MODULID'      => $request->modulid,
                    'KATEGORIID'   => $request->kategoriid,
                    'JUDUL_MATERI' => $request->judul_materi,
                    'SUMBER'       => $request->sumber,
                    'UPDATED_AT'   => now()->format('d-M-y h.i.s A'),
                ],
                'conditions' => [
                    'IDMATERI' => $idmateri
                ],
                'operators' => [""]
            ];

            // dd($payload);
            // Kirim ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.materi.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idmateri= decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'materi tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'materi',
                'conditions' => [
                    'IDMATERI' => $idmateri
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.materi.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.materi.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
