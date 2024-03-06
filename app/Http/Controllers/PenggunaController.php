<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class PenggunaController extends Controller
{
    public function pengguna()
    {
        return view('users.index');
    }
}
