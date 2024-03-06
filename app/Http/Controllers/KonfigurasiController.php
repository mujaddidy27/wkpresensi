<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lokasi_kantor = DB::table('lokasis')->where('lokasis.id', 1)->first();
        $lastProject = $lokasi_kantor->count();

        $project = 'LWK0' . ($lastProject + 1);

        return view('konfigurasi.lokasi', compact('lokasi_kantor', 'project'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('lokasis')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius,
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function jamkerja()
    {

        $jam_kerja = DB::table('jams')->orderBy('kode_shift')->get();
        $lastProject = $jam_kerja->count();

        $project = 'SWK0' . ($lastProject + 1);
        $title = "Konfigurasi";
        return view('konfigurasi.jamkerja', compact('title','jam_kerja', 'project'));
    }

    public function store(Request $request)
    {
        $kode_shift = $request->kode_shift;
        $nama_shift = $request->nama_shift;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        try {
            $data = [
                'kode_shift' => $kode_shift,
                'nama_shift' => $nama_shift,
                'awal_jam_masuk' => $awal_jam_masuk,
                'jam_masuk' => $jam_masuk,
                'akhir_jam_masuk' => $akhir_jam_masuk,
                'jam_pulang' => $jam_pulang,
            ];
            DB::table('jams')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);

        } catch (\Throwable $th) {
            return Redirect::back()->with(['success' => 'Data Gagal Disimpan !']);
        }
    }

    public function editjam(Request $request)
    {
        $kode_shift = $request->kode_shift;
        $jams = DB::table('jams')->where('kode_shift', $kode_shift)->first();
        return view('konfigurasi.edit', compact('jams'));
    }

    public function update($kode_shift, Request $request)
    {
        $kode_shift = $request->kode_shift;
        $nama_shift = $request->nama_shift;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        try {
            $data = [
                'kode_shift' => $kode_shift,
                'nama_shift' => $nama_shift,
                'awal_jam_masuk' => $awal_jam_masuk,
                'jam_masuk' => $jam_masuk,
                'akhir_jam_masuk' => $akhir_jam_masuk,
                'jam_pulang' => $jam_pulang,
            ];
            $update = DB::table('jams')->where('kode_shift', $kode_shift)->update($data);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate !']);
        }
    }

    public function delete($kode_shift)
    {
        $delete = DB::table('jams')->where('kode_shift', $kode_shift)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus !']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus !']);

        }
    }

    public function setjamkerja($nik)
    {
        return view('konfigurasi.setjamkerja');
    }
}
