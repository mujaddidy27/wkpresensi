<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = DB::table('cabangs')->orderBy('kode_cab')->get();
        $lastProject = $cabang->count();

        $project = 'KWK0' . ($lastProject + 1);
        $title = "Cabang";
        return view('cabang.index', compact('title','cabang','project'));
    }

    public function store(Request $request)
    {

        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'kode_cab' => $kode_cabang,
                'nama_cab' => $nama_cabang,
                'lokasi_cab' => $lokasi_cabang,
                'radius' => $radius_cabang,
            ];
            DB::table('cabangs')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan !']);
        }
    }

    public function edit(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $cabang = DB::table('cabangs')->where('kode_cab', $kode_cabang)->first();
        return view('cabang.edit', compact('cabang'));
    }

    public function update($kode_cab, Request $request)
    {
        $kode_cabang = $request->kode_cab;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'kode_cab' => $kode_cabang,
                'nama_cab' => $nama_cabang,
                'lokasi_cab' => $lokasi_cabang,
                'radius' => $radius_cabang,
            ];
            $update = DB::table('cabangs')->where('kode_cab', $kode_cabang)->update($data);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate !']);
        }
    }

    public function delete($kode_cab)
    {
        $delete = DB::table('cabangs')->where('kode_cab', $kode_cab)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus !']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus !']);

        }
    }
}
