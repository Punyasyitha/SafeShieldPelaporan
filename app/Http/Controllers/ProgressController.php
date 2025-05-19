<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    function index()
    {
        $data = [
            'url' => url('user/progress'),
            'list' => DB::table('pengaduan')
                ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
                ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
                ->orderBy('pengaduan.idpengaduan', 'asc')
                ->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            ],
        ];
        // dd($data['list']);

        return view('user.progress.list', $data);
    }
}
