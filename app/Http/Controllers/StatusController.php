<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index($data)
    {
        $data['list'] = DB::table('mst_sts_pengaduan')
            ->orderBy('idstatus', 'asc') // Mengurutkan berdasarkan idstatus
            ->get();
        return view($data['url'],$data);
    }
}