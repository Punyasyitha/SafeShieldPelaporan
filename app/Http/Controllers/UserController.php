<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('user'); // 🔒 Middleware admin diterapkan
    }

    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('user/dashboard'),
            'list' => DB::table('artikel')
                ->join('mst_penulis', 'artikel.penulisid', '=', 'mst_penulis.idpenulis')
                ->select('artikel.*', 'mst_penulis.nama_penulis')
                ->where('artikel.status', 'published') // hanya tampilkan yang statusnya 'published'
                ->orderBy('artikel.idartikel', 'asc')
                ->paginate(10),
        ];
        // dd($data['list']);

        return view('user.dashboard', $data);
    }

    public function show($id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $artikel = DB::table('artikel')
            ->join('mst_penulis', 'artikel.penulisid', '=', 'mst_penulis.idpenulis')
            ->select('artikel.*', 'mst_penulis.nama_penulis')
            ->where('artikel.idartikel', $idartikel)
            ->first();

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }

        return view('user.artikel.show', compact('artikel'));
    }
}
