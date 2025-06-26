<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Pengaduan;
use App\Models\MstModul;
use App\Models\MstKategori;
use App\Models\MstPenulis;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin'); // 🔒 Middleware admin diterapkan
    }

    public function index()
    {
        // Data statistik jumlah
        $pengaduanBaru = Pengaduan::whereMonth('tanggal_kejadian', Carbon::now()->month)->count();
        $statusBaru = MstModul::whereMonth('created_at', Carbon::now()->month)->count();
        $modulBaru = MstModul::whereMonth('created_at', Carbon::now()->month)->count();
        $kategoriBaru = MstKategori::whereMonth('created_at', Carbon::now()->month)->count();
        $penulisBaru = MstPenulis::whereMonth('created_at', Carbon::now()->month)->count();

        // Grafik bar: jumlah per tanggal dalam 1 bulan
        $barChart = Pengaduan::select(
            DB::raw("DATE_FORMAT(tanggal_kejadian, '%Y-%m-%d') as tanggal"), // Mengambil tanggal lengkap
            DB::raw("COUNT(*) as total") // Menghitung total untuk setiap tanggal
        )
            ->whereMonth('tanggal_kejadian', Carbon::now()->month) // Filter berdasarkan bulan saat ini
            ->whereYear('tanggal_kejadian', Carbon::now()->year) // Filter berdasarkan tahun saat ini
            ->groupBy(DB::raw("DATE_FORMAT(tanggal_kejadian, '%Y-%m-%d')")) // Kelompokkan berdasarkan tanggal
            ->orderBy(DB::raw("DATE_FORMAT(tanggal_kejadian, '%Y-%m-%d')")) // Urutkan berdasarkan tanggal
            ->get();

        // Grafik pie: jumlah pengaduan berdasarkan status
        $pieChart = DB::table('pengaduan as p')
            ->join('mst_sts_pengaduan as s', 'p.statusid', '=', 's.idstatus')
            ->select('s.nama_status', DB::raw('count(*) as total'))
            ->groupBy('s.nama_status')
            ->get();

        // Progress penyelesaian pengaduan bulan ini
        $totalBulanIni = Pengaduan::whereMonth('created_at', Carbon::now()->month)->count();
        $selesaiBulanIni = DB::table('pengaduan')
            ->where('statusid', function ($query) {
                $query->select('idstatus')
                    ->from('mst_sts_pengaduan')
                    ->where('nama_status', 'Selesai')
                    ->limit(1);
            })
            ->whereMonth('updated_at', now()->month)
            ->count();

        $progresSelesai = $totalBulanIni > 0 ? round(($selesaiBulanIni / $totalBulanIni) * 100, 2) : 0;

        return view('admin.dashboard', [
            'pengaduanBaru' => $pengaduanBaru,
            'statusBaru' => $statusBaru,
            'modulBaru' => $modulBaru,
            'kategoriBaru' => $kategoriBaru,
            'penulisBaru' => $penulisBaru,
            'barChart' => $barChart,
            'pieChart' => $pieChart,
            'progresSelesai' => $progresSelesai,
            'selesaiBulanIni' => $selesaiBulanIni,
        ]);
    }
}