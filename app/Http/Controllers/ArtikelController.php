<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'artikel',
            'data'  => '*',
            'limit' => 100, // atau sesuai kebutuhan
        ]);

        if (!$response->successful()) {
            return view('admin.artikel.list', [
                'list' => collect(), // kosongkan list
                'authorize' => (object)['add' => '1'],
                'url' => url('admin/artikel'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response->json()['data'] ?? [])
            ->map(fn($item) => (array) $item)
            ->sortBy(fn($item) => (int) $item['IDARTIKEL'] ?? 0) // urutkan berdasarkan numerik
            ->values(); // reset index array supaya $index + 1 di blade tetap konsisten

        return view('admin.artikel.list', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/artikel'),
        ]);
        //dd($data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];

        // Ambil data penulis dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_penulis',
            'data'  => '*',
            'limit' => 100,
        ]);

        // Cek apakah response berhasil
        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data penulis');
        }

        $result = $response->json();
        $penulis = collect($result['data'] ?? []); // handle jika data kosong

        return view('admin.artikel.add', [
            'authorize' => $authorize,
            'url'       => 'admin/artikel',
            'penulis'   => $penulis,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penulisid'      => 'required|exists:mst_penulis,idpenulis',
            'judul_artikel'  => 'required|string|max:255',
            'isi_artikel'    => 'required|string',
            'tanggal_rilis'  => 'required|date',
            'status'         => 'required|in:draft,published,archived',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,svg,webp|max:102400', // 100MB
        ]);

        try {
            $gambarPath = null;

            // Upload file gambar jika ada
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $filename = time() . '-' . $gambar->getClientOriginalName();
                $gambarPath = Storage::disk('public')->putFileAs('artikel', $gambar, $filename);
            }

            // Format payload untuk API
            $payload = [
                'table' => 'artikel',
                'data' => [
                    [
                        'penulisid'     => $request->penulisid,
                        'judul_artikel' => $request->judul_artikel,
                        'isi_artikel'   => $request->isi_artikel,
                        'tanggal_rilis' => [
                            'type' => 'date',
                            'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tanggal_rilis)->format('d-m-Y')
                        ],
                        'gambar'        => $gambarPath,
                        'status'        => $request->status,
                        'created_at'    => now()->format('d-M-y h.i.s A'),
                        'updated_at'    => now()->format('d-M-y h.i.s A'),
                    ]
                ]
            ];

            // Kirim ke API eksternal
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Gagal menyimpan data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.artikel.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idartikel = decrypt($id);
            // dd(['idartikel' => decrypt($id)]);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'artikel',
                'data'   => '*', // ambil semua kolom
                'filter' => [
                    'IDARTIKEL' => $idartikel
                ],
                'limit' => 1 // hanya ambil 1 baris (karena idartikel unik)
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $art = (object) $result['data'][0];

            return view('admin.artikel.show', [
                'art' => $art,
                'url' => 'admin/artikel',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idartikel = decrypt($id);

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table'  => 'artikel',
                'data'   => '*',
                'filter' => [
                    'IDARTIKEL' => $idartikel
                ],
                'limit' => 1
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $art = (object) $result['data'][0];

            // Ambil data penulis
            $responsePenulis = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_penulis',
                'data'  => '*',
                'limit' => 100,
            ]);

            $penulis = collect($responsePenulis['data'] ?? [])->map(function ($item) {
                return (object) $item;
            });

            return view('admin.artikel.edit', [
                'art'     => $art,
                'penulis' => $penulis,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penulisid'      => 'required|exists:mst_penulis,idpenulis',
            'judul_artikel'  => 'required|string|max:255',
            'isi_artikel'    => 'required|string',
            'tanggal_rilis'  => 'required|date',
            'status'         => 'required|in:draft,published,archived',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,svg,webp|max:102400',
        ]);

        try {
            $idartikel = decrypt($id); // pastikan ID terenkripsi di route

            $gambarPath = $request->old_gambar ?? null;

            // Jika user centang checkbox hapus gambar
            if ($request->has('hapus_gambar')) {
                $gambarPath = null;

                // (Opsional) Hapus file lama juga dari storage
                if ($request->old_gambar && Storage::disk('public')->exists($request->old_gambar)) {
                    Storage::disk('public')->delete($request->old_gambar);
                }
            }

            // Jika user upload gambar baru
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $filename = time() . '-' . $gambar->getClientOriginalName();
                $gambarPath = Storage::disk('public')->putFileAs('artikel', $gambar, $filename);
            }

            // Format payload update
            $payload = [
                'table' => 'artikel',
                'data' => [
                    'PENULISID'     => $request->penulisid,
                    'JUDUL_ARTIKEL' => $request->judul_artikel,
                    'ISI_ARTIKEL'   => $request->isi_artikel,
                    'TANGGAL_RILIS' => [
                        'type' => 'date',
                        'value' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->tanggal_rilis)->format('d-m-Y')
                    ],
                    'GAMBAR'        => $gambarPath,
                    'STATUS'        => $request->status,
                    'UPDATED_AT'    => now()->format('d-M-y h.i.s A'),
                ],
                'conditions' => [
                    'IDARTIKEL' => $idartikel
                ],
                'operators' => [""]
            ];
            //dd($payload);
            // Kirim update ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/update_up2k', $payload);

            if (!$response->successful()) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Gagal mengupdate data ke API eksternal: ' . $response->body());
            }

            $result = $response->json();
            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.artikel.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Artikel tidak valid');
        }

        try {
            // Kirim request DELETE ke API
            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/delete_up2k', [
                'table' => 'artikel',
                'conditions' => [
                    'IDARTIKEL' => $idartikel
                ],
                'operators' => [""] // kosongkan karena hanya 1 kondisi
            ]);

            if (!$response->successful()) {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'Gagal menghapus data dari API eksternal: ' . $response->body());
            }

            $result = $response->json();

            if (!empty($result['data'][0]['status']) && $result['data'][0]['status'] === 'gagal') {
                return redirect()->route('admin.artikel.list')
                    ->with('error', 'API Gagal: ' . ($result['data'][0]['deskripsi'] ?? ''));
            }

            return redirect()->route('admin.artikel.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
