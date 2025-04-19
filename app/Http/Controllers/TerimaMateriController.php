<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerimaMateriController extends Controller
{
    public function index()
    {
        $rawList = DB::table('materi')
            ->join('mst_modul', 'materi.modulid', '=', 'mst_modul.idmodul')
            ->join('mst_kategori', 'materi.kategoriid', '=', 'mst_kategori.idkategori')
            ->select('materi.*', 'mst_modul.nama_modul', 'mst_modul.deskripsi', 'mst_kategori.nama_kategori')
            ->orderBy('materi.idmateri', 'asc')
            ->get();

        // Group by modulid
        $grouped = $rawList->groupBy('modulid');

        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('user/materi'),
            'grouped' => $grouped,
        ];

        return view('user.materi.list', $data);
    }
}
