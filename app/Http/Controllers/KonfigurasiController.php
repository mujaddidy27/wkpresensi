<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor(){
        $lokasi_kantor = DB::table('lokasis')->where('lokasis.id', 1)->first();
        return view('konfigurasi.lokasi', compact('lokasi_kantor'));
    }

    public function updatelokasikantor(Request $request){
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('lokasis')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['warning'=>'Data Gagal Diupdate']);
        }
    }
}
