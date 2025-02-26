<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin'); // 🔒 Middleware admin diterapkan
    }

    public function index()
    {
        // ✅ Set hak akses untuk admin (misalnya, hanya admin yang bisa menambah)
        $authorize = (object)['add' => '1'];

        return view('admin.dashboard', [
            'authorize' => $authorize, // 🔹 Kirim ke view
            'url_menu' => 'admin/dashboard',
        ]);
    }
}
