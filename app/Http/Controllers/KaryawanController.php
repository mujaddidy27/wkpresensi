<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawans.*', 'nama', 'nama_cab');
        $query->join('departemens', 'karyawans.kode_dpt', '=', 'departemens.kode');
        $query->join('cabangs', 'karyawans.kode_cab', '=', 'cabangs.kode_cab');

        $query->orderBy('nama_lengkap');

        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        if (!empty($request->kode_dpt)) {
            $query->where('karyawans.kode_dpt', $request->kode_dpt);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemens')->get();
        $cabang = DB::table('cabangs')->get();
        $lastProject = $query->count();

        $project = 'WK-00' . ($lastProject + 1) . '-' . date('Y');
        $title = "Karyawan";
        return view('karyawan.index', compact('title','karyawan', 'departemen', 'cabang', 'project'));

    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $kode_cabang = $request->kode_cabang;

        $password = Hash::make('1234');
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'kode_cab' => $kode_cabang,
                'foto' => $foto,
                'password' => $password,
            ];
            $simpan = DB::table('karyawans')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
            }
        } catch (\Throwable $th) {
            // if ($th->getCode() == 23000) {
            //     $message = 'Data dengan NIK ' . $nik . ' sudah terdaftar !';
            // }

            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ! ' . $message]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemens')->get();
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $cabang = DB::table('cabangs')->orderBy('kode_cab')->get();
        $title = "Karyawan";
        return view('karyawan.edit', compact('title','departemen', 'karyawan', 'cabang'));

    }
    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $kode_cab = $request->kode_cab;

        $password = Hash::make('1234');
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $old_foto = $karyawan->foto;
        $new = $request->hasFile('foto');
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'kode_cab' => $kode_cab,
                'foto' => $foto,
                'password' => $password,
            ];
            $update = DB::table('karyawans')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $karyawan->foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate !']);
        }
    }
    public function delete($nik)
    {
        $delete = DB::table('karyawans')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus !']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus !']);

        }
    }

    public function pengguna()
    {
        $users = DB::table('users')->orderBy('id')->get();
        $title = "Users";
        return view('users.index', compact('title','users'));
    }

    public function tambahpengguna(Request $request)
    {
        $name = $request->nama;
        $email = $request->email;
        $pass = $request->password;
        $password = Hash::make($pass);
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ];
            $simpan = DB::table('users')->insert($data);
            if ($simpan) {
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
            }
        } catch (\Throwable $th) {
            // if ($th->getCode() == 23000) {
            //     $message = 'Data dengan NIK ' . $nik . ' sudah terdaftar !';
            // }

            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ! ' . $message]);
        }

    }

    public function deleteuser($nik)
    {
        $delete = DB::table('users')->where('id', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus !']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus !']);

        }

    }

}
