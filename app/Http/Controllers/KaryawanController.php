<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class KaryawanController extends Controller
{
    public function index(Request $request){

        $query = Karyawan::query();
        $query->select('karyawans.*', 'nama');
        $query->join('departemens', 'karyawans.kode_dpt', '=','departemens.kode');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_karyawan)){
            $query->where('nama_lengkap','like','%'.$request->nama_karyawan.'%');
        }
        if(!empty($request->kode_dpt)){
            $query->where('karyawans.kode_dpt', $request->kode_dpt);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemens')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

    public function store(Request $request){
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $password = Hash::make('1234');
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $karyawan->foto;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawans')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath= "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan !']);
         }
    }

    public function edit(Request $request){
        $nik = $request->nik;
        $departemen = DB::table('departemens')->get();
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen','karyawan'));
    }
    public function update($nik, Request $request){
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $password = Hash::make('1234');
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $old_foto = $karyawan->foto;
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('karyawans')->where('nik', $nik)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath= "public/uploads/karyawan/";
                    $folderPathOld= "public/uploads/karyawan/".$karyawan->foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate !']);
         }
    }
    public function delete($nik) {
        $delete = DB::table('karyawans')->where('nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus !']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Dihapus !']);

        }
    }
}
