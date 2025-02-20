<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function user()
    {
        return view('user.dashboard');
    }
}