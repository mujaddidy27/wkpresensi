<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Departemen;

class DepartemenController extends Controller
{
    public function index(Request $request){
        $nama_dpt = $request->nama_dpt;
        $query = Departemen::query();
        $query->select('*');
        if(!empty($nama_dpt)){
            $query->where('nama','like','%'.$nama_dpt.'%');
        }
        $departemen = $query->get();
        // $karyawan = $query->paginate(10);
        // $departemen = DB::table('departemens')->orderBy('kode')->get();
        return view('departemen.index', compact('departemen'));
    }
    public function store(Request $request){
        $kode_dpt = $request->kode_dpt;
        $nama_dpt = $request->nama_dpt;
        try {
            $data = [
                'kode' => $kode_dpt,
                'nama' => $nama_dpt
            ];

            $simpan = DB::table('departemens')->insert($data);
            if($simpan){
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan !']);
        }
    }

    public function edit(Request $request){
        $kode_dpt = $request->kode_dpt;
        $departemen = DB::table('departemens')->where('kode', $kode_dpt)->first();
        return view('departemen.edit', compact('departemen'));
    }

    public function update($kode, Request $request){
        $kode_dpt = $request->kode;
        $nama_dpt = $request->nama_dpt;
        try {
            $data = [
                'kode' => $kode_dpt,
                'nama' => $nama_dpt,
            ];
            $update = DB::table('departemens')->where('kode', $kode_dpt)->update($data);
            if($update){
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate !']);
         }
    }

    public function delete($kode) {
        $delete = DB::table('departemens')->where('kode', $kode)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus !']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Dihapus !']);

        }
    }
}
