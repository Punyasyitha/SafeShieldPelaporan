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
        // ✅ Set hak akses untuk admin (misalnya, hanya admin yang bisa menambah)
        $authorize = (object)['add' => '1'];

        return view('user.dashboard', [
            'authorize' => $authorize, // 🔹 Kirim ke view
            'url_menu' => 'user/dashboard',
        ]);
    }
}
