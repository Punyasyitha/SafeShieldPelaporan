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
                'url' => url('admin/master/submateri'),
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
            'url' => url('admin/master/submateri'),
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
        } catch (\Exception $e) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')
            ->join('materi', 'submateri.materiid', '=', 'materi.idmateri')
            ->select('submateri.*', 'materi.judul_materi')
            ->where('submateri.idsubmateri', $idsubmateri)
            ->first();

        if (!$submateri) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        return view('admin.submateri.show', compact('submateri'));
    }

    public function edit($id)
    {
        try {
            $idsubmateri = decrypt($id); // Jika ID tidak dienkripsi, langsung pakai $id
        } catch (\Exception $e) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')
            ->where('idsubmateri', $idsubmateri) // Pakai hasil dekripsi
            ->first();

        if (!$submateri) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $materi = DB::table('materi')->get();

        return view('admin.submateri.edit', compact('submateri', 'materi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materiid'        => 'required|exists:materi,idmateri',
            'judul_submateri' => 'required|string|max:255',
            'isi'             => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $idsubmateri = decrypt($id); // Jika ID dalam URL terenkripsi, dekripsi dulu

            $affectedRows = DB::table('submateri')
                ->where('idsubmateri', $idsubmateri) // Gunakan hasil dekripsi
                ->update([
                    'materiid'        => $request->materiid,
                    'judul_submateri' => $request->judul_submateri,
                    'isi'             => $request->isi,
                    'updated_at'      => now(),
                ]);

            DB::commit();

            // Jika tidak ada baris yang diperbarui, kirim pesan warning
            if ($affectedRows === 0) {
                return redirect()->route('admin.submateri.list')
                    ->with('warning', 'Tidak ada perubahan data!');
            }

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idsubmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')->where('idsubmateri', $idsubmateri)->first();
        if (!$submateri) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Materi tidak ditemukan.');
        }

        try {
            DB::table('submateri')->where('idsubmateri', $idsubmateri)->delete();
            return redirect()->route('admin.submateri.list')
                ->with('success', 'Materi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Terjadi kesalahan saat menghapus materi: ' . $e->getMessage());
        }
    }
}
