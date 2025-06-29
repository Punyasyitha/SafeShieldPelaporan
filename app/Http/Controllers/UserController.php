<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('user'); // 🔒 Middleware admin diterapkan
    }

    public function index()
    {
        // Ambil data artikel dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'artikel',
            'data'  => '*',
            'limit' => 100,
        ]);

        // Ambil data penulis dari API
        $responsePenulis = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_penulis', // atau nama tabel sebenarnya
            'data'  => '*',
        ]);

        if (!$response->successful()) {
            return view('user.dashboard', [
                'list' => collect(),
                'authorize' => (object)['add' => '1'],
                'url' => url('user/dashboard'),
                'error' => 'Gagal fetch data dari API',
            ]);
        }

        // Buat mapping IDPENULIS => NAMA_PENULIS
        $penulisMap = collect($responsePenulis['data'] ?? [])
            ->pluck('NAMA_PENULIS', 'IDPENULIS');

        // Mapping data artikel dan isi nama penulis
        $data = collect($response->json()['data'] ?? [])
            ->map(function ($item) use ($penulisMap) {
                $item = (array) $item;
                $item['NAMA_PENULIS'] = $penulisMap[$item['PENULISID']] ?? 'Penulis Tidak Diketahui';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDARTIKEL'] ?? 0)
            ->values();
        // dd($data->first());

        return view('user.dashboard', [
            'list' => $data,
            'authorize' => (object)['add' => '1'],
            'url' => url('user/dashboard'),
        ]);
    }


    public function show($id)
    {
        try {
            $idartikel = decrypt($id);

            // Ambil data artikel berdasarkan ID
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
                return redirect()->route('user.dashboard')
                    ->with('error', 'Gagal mengambil data dari API.');
            }

            $result = $response->json();

            if (empty($result['data']) || count($result['data']) == 0) {
                return redirect()->route('user.dashboard')
                    ->with('error', 'Data tidak ditemukan di API.');
            }

            $art = (array) $result['data'][0]; // ubah ke array

            // Ambil data penulis dari API
            $responsePenulis = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'mst_penulis',
                'data'  => '*',
            ]);

            // Mapping penulis ID => Nama
            $penulisMap = collect($responsePenulis['data'] ?? [])
                ->pluck('NAMA_PENULIS', 'IDPENULIS');

            // Isi NAMA_PENULIS jika ada
            $penulisId = $art['PENULISID'] ?? null;
            $art['NAMA_PENULIS'] = $penulisMap[$penulisId] ?? 'Penulis Tidak Diketahui';

            return view('user.artikel.show', [
                'art' => (object) $art,
                'url' => 'admin/artikel',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
