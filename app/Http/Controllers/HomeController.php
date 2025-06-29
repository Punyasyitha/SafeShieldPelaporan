<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Pengaduan;
use App\Models\MstModul;
use App\Models\MstKategori;
use App\Models\MstPenulis;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin'); // 🔒 Middleware admin diterapkan
    }

    public function index()
    {
        // Ambil data dari masing-masing tabel via API
        $modulData = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_modul',
            'data'  => '*',
            'limit' => 1000,
        ])->json()['data'] ?? [];
        // dd($modulData);

        $kategoriData = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_kategori',
            'data'  => '*',
            'limit' => 1000,
        ])->json()['data'] ?? [];

        $penulisData = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_penulis',
            'data'  => '*',
            'limit' => 1000,
        ])->json()['data'] ?? [];

        $statusData = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
            'limit' => 1000,
        ])->json()['data'] ?? [];
        // dd($statusData);

        $currentMonth = now()->format('m'); // Gunakan string untuk format yang aman perbandingannya

        $modulBaru = collect($modulData)->filter(function ($item) use ($currentMonth) {
            $created = $this->parseOracleDatetime($item['CREATED_AT'] ?? null);
            return $created && $created->format('m') === $currentMonth;
        })->count();

        $kategoriBaru = collect($kategoriData)->filter(function ($item) use ($currentMonth) {
            $created = $this->parseOracleDatetime($item['CREATED_AT'] ?? null);
            return $created && $created->format('m') === $currentMonth;
        })->count();

        $penulisBaru = collect($penulisData)->filter(function ($item) use ($currentMonth) {
            $created = $this->parseOracleDatetime($item['CREATED_AT'] ?? null);
            return $created && $created->format('m') === $currentMonth;
        })->count();

        $statusTotal = collect($statusData)->count();

        // Misal ini data total semua
        $totalModul = count($modulData);
        $totalKategori = count($kategoriData);
        $totalPenulis = count($penulisData);

        // Pastikan pembagi tidak nol agar tidak error
        $persentaseModul = $totalModul > 0 ? round(($modulBaru / $totalModul) * 100, 1) : 0;
        $persentaseKategori = $totalKategori > 0 ? round(($kategoriBaru / $totalKategori) * 100, 1) : 0;
        $persentasePenulis = $totalPenulis > 0 ? round(($penulisBaru / $totalPenulis) * 100, 1) : 0;

        // Ambil data pengaduan
        $pengaduanResponse = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'pengaduan',
            'data'  => '*',
            'limit' => 1000,
        ]);

        // Ambil referensi status pengaduan
        $statusResponse = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
        ]);

        $pengaduanData = collect($pengaduanResponse['data'] ?? []);
        $statusList = collect($statusResponse['data'] ?? []);
        $statusMap = $statusList->pluck('NAMA_STATUS', 'IDSTATUS');

        $now = Carbon::now();

        // 1. Jumlah pengaduan bulan ini
        $pengaduanBaru = $pengaduanData->filter(function ($item) use ($now) {
            $date = $this->parseOracleDatetime($item['TANGGAL_KEJADIAN'] ?? null);
            return $date && $date->month === $now->month;
        })->count();

        // 2. Bar Chart: jumlah pengaduan per tanggal bulan ini
        $barChart = $pengaduanData
            ->filter(function ($item) use ($now) {
                $tanggal = $this->parseOracleDatetime($item['TANGGAL_KEJADIAN'] ?? null);
                return $tanggal && $tanggal->month === $now->month;
            })
            ->groupBy(function ($item) {
                $tanggal = $this->parseOracleDatetime($item['TANGGAL_KEJADIAN'] ?? null);
                return $tanggal ? $tanggal->format('Y-m-d') : 'Invalid';
            })
            ->map(function ($group) {
                $tanggal = $this->parseOracleDatetime($group->first()['TANGGAL_KEJADIAN'] ?? null);
                return [
                    'tanggal' => $tanggal ? $tanggal->format('Y-m-d') : 'Invalid',
                    'total'   => $group->count()
                ];
            })
            ->filter(fn($row) => $row['tanggal'] !== 'Invalid') // Optional: buang data yang gagal parsing
            ->values();

        // 3. Pie Chart: jumlah pengaduan per nama status
        $pieChart = $pengaduanData
            ->groupBy('STATUSID')
            ->map(function ($group, $statusId) use ($statusMap) {
                return [
                    'nama_status' => $statusMap[$statusId] ?? 'Tidak Diketahui',
                    'total' => $group->count(),
                ];
            })->values();

        // 4. Progress penyelesaian
        $totalBulanIni = $pengaduanData->filter(function ($item) use ($now) {
            $created = $this->parseOracleDatetime($item['CREATED_AT'] ?? null);
            return $created && $created->month === $now->month;
        })->count();


        $selesaiBulanIni = $pengaduanData->filter(function ($item) use ($now, $statusMap) {
            $statusNama = $statusMap[$item['STATUSID']] ?? null;
            $updated = $this->parseOracleDatetime($item['UPDATED_AT'] ?? null);
            return $statusNama === 'Selesai' &&
                $updated &&
                $updated->month === $now->month;
        })->count();

        $progresSelesai = $totalBulanIni > 0 ? round(($selesaiBulanIni / $totalBulanIni) * 100, 2) : 0;

        // Kirim ke view
        return view('admin.dashboard', compact(
            'modulBaru',
            'kategoriBaru',
            'penulisBaru',
            'statusTotal',
            'persentaseModul',
            'persentaseKategori',
            'persentasePenulis',
            'pengaduanBaru',
            'barChart',
            'pieChart',
            'selesaiBulanIni',
            'progresSelesai'
        ));
    }

    private function parseOracleDatetime($value)
    {
        if (!$value) return null;

        // Hapus bagian microseconds (.000000)
        $cleaned = preg_replace('/\.\d{6}/', '', $value);

        try {
            // Parsing format dari Oracle: 25-JUN-25 05.06.47 AM
            return \Carbon\Carbon::createFromFormat('d-M-y h.i.s A', $cleaned);
        } catch (\Exception $e) {
            // Tangani jika format tidak sesuai
            return null;
        }
    }
}
