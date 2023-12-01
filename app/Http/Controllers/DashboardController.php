<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $hariini = date('Y-m-d');
        $bulanini = date('m')*1;
        $tahunini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $absenhariini = DB::table('presensis')
        ->where('nik', $nik)
        ->where('tgl_absen', $hariini)
        ->first();
        $historybulanini = DB::table('presensis')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_absen)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_absen)="'.$tahunini.'"')
        ->orderBy('tgl_absen')
        ->get();
        $rekapabsen = DB::table('presensis')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_absen)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_absen)="'.$tahunini.'"')
        ->first();
        $liderboard = DB::table('presensis')
        ->join('karyawans', 'presensis.nik','=','karyawans.nik')
        ->where('tgl_absen', $hariini)
        ->orderBy('jam_in')
        ->get();

        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        $rekapizin = DB::table('izins')
        ->selectRaw('SUM(IF(status_izin="i",1,0)) as jmlizin, SUM(IF(status_izin="s",1,0)) as jmlsakit ')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_izin)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_izin)="'.$tahunini.'"')
        ->where('status', 1)
        ->first();
        return view('dashboard.dashboard', compact('absenhariini','historybulanini','namabulan','bulanini','tahunini','rekapabsen','liderboard','rekapizin'));
    }

    public function dashboardadmin(){

        $rekapkaryawan = DB::table('karyawans')
        ->selectRaw('COUNT(nik) as jmlkaryawan')
        ->first();
        $hariini = date("Y-m-d");
        $rekapabsen = DB::table('presensis')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('tgl_absen', $hariini)
        ->first();
        $rekapizin = DB::table('izins')
        ->selectRaw('SUM(IF(status_izin="i",1,0)) as jmlizin, SUM(IF(status_izin="s",1,0)) as jmlsakit ')
        ->where('tgl_izin', $hariini)
        ->where('status', 1)
        ->first();

        return view('dashboard.dashboardadmin', compact('rekapkaryawan','rekapabsen','rekapizin'));
    }
}
