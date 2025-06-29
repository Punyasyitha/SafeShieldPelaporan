<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerimaMateriController extends Controller
{
    public function index()
    {
        // Ambil data materi
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'materi',
            'data'  => '*',
            'limit' => 100,
        ]);

        // Ambil data modul
        $responseModul = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_modul',
            'data'  => '*',
        ]);

        // Ambil data kategori
        $responseKategori = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_kategori',
            'data'  => '*',
        ]);

        if (!$response->successful()) {
            return view('user.materi.list', [
                'list'      => collect(),
                'grouped'   => collect(),
                'authorize' => (object)['add' => '1'],
                'url'       => url('user/materi'),
                'error'     => 'Gagal fetch data dari API',
            ]);
        }

        $modulMap = collect($responseModul['data'] ?? [])->pluck('NAMA_MODUL', 'IDMODUL');
        $kategoriMap = collect($responseKategori['data'] ?? [])->pluck('NAMA_KATEGORI', 'IDKATEGORI');

        $data = collect($response->json()['data'] ?? [])
            ->map(function ($item) use ($modulMap, $kategoriMap) {
                $item = (array) $item;
                $item['NAMA_MODUL']    = $modulMap[$item['MODULID']] ?? 'Modul Tidak Diketahui';
                $item['NAMA_KATEGORI'] = $kategoriMap[$item['KATEGORIID']] ?? 'Kategori Tidak Diketahui';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDMATERI'] ?? 0)
            ->values();

        $grouped = $data->groupBy('MODULID');

        return view('user.materi.list', [
            'list'      => $data,
            'grouped'   => $grouped,
            'authorize' => (object)['add' => '1'],
            'url'       => url('user/materi'),
        ]);
    }

    public function show($id)
    {
        try {
            $idsubmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        // Ambil semua data submateri dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'submateri',
            'data'  => '*',
        ]);

        // Ambil data materi
        $responseMateri = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'materi',
            'data'  => '*',
        ]);

        // Ambil data modul
        $responseModul = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_modul',
            'data'  => '*',
        ]);

        // Ambil data kategori
        $responseKategori = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_kategori',
            'data'  => '*',
        ]);

        // Mapping referensi
        $materiMap    = collect($responseMateri['data'] ?? [])->keyBy('IDMATERI');
        $modulMap     = collect($responseModul['data'] ?? [])->pluck('NAMA_MODUL', 'IDMODUL');
        $kategoriMap  = collect($responseKategori['data'] ?? [])->pluck('NAMA_KATEGORI', 'IDKATEGORI');

        // Ambil semua submateri dan mapping nama modul & kategori via materi
        $submateriAll = collect($response['data'] ?? [])
            ->map(function ($item) use ($materiMap, $modulMap, $kategoriMap) {
                $item = (array) $item;
                $materi = $materiMap[$item['MATERIID']] ?? null;

                $item['JUDUL_MATERI']   = $materi['JUDUL_MATERI'] ?? '-';
                $item['NAMA_MODUL']     = $modulMap[$materi['MODULID']] ?? 'Modul Tidak Diketahui';
                $item['NAMA_KATEGORI']  = $kategoriMap[$materi['KATEGORIID']] ?? 'Kategori Tidak Diketahui';

                return $item;
            });

        // Temukan submateri utama berdasarkan ID yang didecrypt
        $submateriUtama = $submateriAll->firstWhere('IDSUBMATERI', $idsubmateri);

        if (!$submateriUtama) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        // Ambil semua submateri lain yang punya judul_materi yang sama
        $submateris = $submateriAll->filter(function ($item) use ($submateriUtama) {
            return $item['JUDUL_MATERI'] === $submateriUtama['JUDUL_MATERI'];
        });
        $submateris = $submateris->map(fn($item) => (object) $item);

        return view('user.materi.show', [
            'submateriUtama' => (object) $submateriUtama,
            'submateris'     => $submateris,
        ]);
    }
}
