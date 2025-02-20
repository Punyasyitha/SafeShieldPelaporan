<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SatgasController extends Controller
{
    function satgas()
    {
        return view('satgas.dashboard');
    }
}