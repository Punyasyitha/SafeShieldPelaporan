<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanRekapController extends Controller
{
    public function index()
    {
        $fromDate = request()->input('from_date');
        $toDate = request()->input('to_date');
        $statusId = request()->input('statusid');

        $query = DB::table('pengaduan')
            ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
            ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status');

        // Filter berdasarkan tanggal jika ada
        if ($fromDate && $toDate) {
            $query->whereBetween('pengaduan.tanggal_kejadian', [$fromDate, $toDate]);
        }

        // Filter berdasarkan status jika ada
        if ($statusId) {
            $query->where('pengaduan.statusid', $statusId);
        }

        $data = [
            'url' => url('admin/report/filter'),
            'list' => $query->orderBy('pengaduan.idpengaduan', 'asc')->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan'  => 'bg-yellow-200 text-yellow-800',
                'Final'     => 'bg-blue-200 text-blue-800',
                'Selesai'   => 'bg-green-200 text-green-800',
            ],
        ];

        return view('admin.report.pengaduan.filter', $data);
    }

    public function result()
    {
        $fromDate = request()->input('from_date');
        $toDate = request()->input('to_date');
        $statusId = request()->input('statusid');

        $query = DB::table('pengaduan')
            ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
            ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status');

        // Filter berdasarkan tanggal pengaduan (jika tersedia)
        if ($fromDate && $toDate) {
            $query->whereBetween('pengaduan.tanggal_kejadian', [$fromDate, $toDate]);
        }

        // Filter berdasarkan status pengaduan (jika tersedia)
        if ($statusId) {
            $query->where('pengaduan.statusid', $statusId);
        }

        $data = [
            'list' => $query->orderBy('pengaduan.idpengaduan', 'asc')->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan'  => 'bg-orange-200 text-orange-800',
                'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
                'Final'      => 'bg-blue-200 text-blue-800',
                'Selesai'    => 'bg-green-200 text-green-800',
            ],
            // Untuk menjaga nilai input agar tetap terisi setelah submit
            'from_date' => $fromDate,
            'to_date'   => $toDate,
            'statusid'  => $statusId,
        ];

        return view('admin.report.pengaduan.result', $data);
    }
}
