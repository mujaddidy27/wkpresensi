<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\izin;



class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensis')->where('tgl_absen', $hariini)->where('nik', $nik)->count();
        $lokasi_kantor = DB::table('lokasis')->where('lokasis.id', 1)->first();
        return view('presensi.create', compact('cek', 'lokasi_kantor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi_kantor = DB::table('lokasis')->where('lokasis.id', 1)->first();
        $lok = explode(",", $lokasi_kantor->lokasi_kantor);
        $latitudekantor = $lok[0] ;
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $cek = DB::table('presensis')->where('tgl_absen', $tgl_presensi)->where('nik', $nik)->count();
        if($cek > 0){
            $ket = "out";
        }else{
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formateName = $nik."-".$tgl_presensi."-".$ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formateName.".png";
        $file = $folderPath.$fileName;

        if ($radius > 20) {
            echo "error|Maaf, Anda berada diluar kantor. Jarak anda $radius meter dari kantor|luar";
        }else{
        if ($cek > 0) {
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('presensis')->where('tgl_absen', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
            if($update){
                echo "success|Terimakasih, Hati-hati di jalan !|out";
                Storage::put($file, $image_base64);
            }else{
                echo "error|Absen gagal, Silahkan hub IT Mas Didy|out";
            }
        } else {
        $data = [
            'nik' => $nik,
            'tgl_absen' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi
        ];
        $simpan = DB::table('presensis')->insert($data);
        if($simpan){
            echo "success|Absen berhasil, Selamat bekerja !|in";
            Storage::put($file, $image_base64);
        }else{
            echo "error|Absen gagal, Silahkan hub IT Mas Didy|in";
        }
        }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    //editprofile
    public function editprofile(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        return view('presensi.editprofile',compact('karyawan'));
    }
    //updateprofile
    public function updateprofile(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = $request->password;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $karyawan->foto;
        }
        if(empty($password)){
        $data = [
            'nama' => $nama,
            'no_hp' => $no_hp,
            'foto' => $foto
        ];

        }else{
            $data = [
                'nama' => $nama,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => Hash::make($password)
            ];
        }

        $update = DB::table('karyawans')->where('nik', $nik)->update($data);

        if($update){
            if($request->hasFile('foto')){
                $folderPath= "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
        }else{
            return Redirect::back()->with(['error'=>'Data gagal diupdate']);
        }

    }

    //history
    public function history(){

        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        return view('presensi.history', compact('namabulan'));
    }
    //gethistory
    public function gethistory(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('presensis')
        ->whereRaw('MONTH(tgl_absen)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_absen)="'.$tahun.'"')
        ->where('nik', $nik)
        ->orderBy('tgl_absen')
        ->get();
        return view('presensi.gethistory', compact('history'));
    }

    //izin
    public function izin(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('izins')->where('nik',$nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }
    //buatizin
    public function buatizin(){
        return view('presensi.buatizin');
    }
    //ajukanizin
    public function ajukanizin(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status_izin' => $status,
             'keterangan_izin' => $keterangan
        ];

    $simpan = DB::table('izins')->insert($data);
    if($simpan){
        return redirect('/presensi/izin')->with(['success'=>'Data Berhasil Disimpan']);
    }else{
        return redirect('/presensi/buatizin')->with(['success'=>'Data Gagal Disimpan']);
    }
    }

    // monitoring
    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')
        ->select('presensis.*','nama_lengkap','nama')
        ->join('karyawans','presensis.nik','=','karyawans.nik')
        ->join('departemens','karyawans.kode_dpt','=','departemens.kode')
        ->where('tgl_absen', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function tampilkanpeta(Request $request){
        $id = $request->id;
        $presensi = DB::table('presensis')->where('presensis.id', $id)
        ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
        ->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporanpresensi(){
        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        $karyawan = DB::table('karyawans')->orderBy('nama_lengkap')->get();
        return view('presensi.laporanpresensi', compact('namabulan','karyawan'));
    }

    public function cetaklaporan(Request $request){
        $nik = $request->karyawan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        $karyawan = DB::table('karyawans')->where('nik', $nik)
        ->join('departemens', 'karyawans.kode_dpt', '=','departemens.kode')
        ->first();
        $presensi = DB::table('presensis')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_absen)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_absen)="'.$tahun.'"')
        ->get();
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekappresensi(){
        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        $karyawan = DB::table('karyawans')->orderBy('nama_lengkap')->get();
        return view('presensi.rekappresensi', compact('namabulan','karyawan'));
    }
    public function cetakrekap(Request $request){
        $namabulan = ["","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September", "Oktober","November","Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensis')
        ->selectRaw('presensis.nik,nama_lengkap,
        MAX(IF(DAY(tgl_absen) = 1, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
        MAX(IF(DAY(tgl_absen) = 2, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
        MAX(IF(DAY(tgl_absen) = 3, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
        MAX(IF(DAY(tgl_absen) = 4, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
        MAX(IF(DAY(tgl_absen) = 5, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
        MAX(IF(DAY(tgl_absen) = 6, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
        MAX(IF(DAY(tgl_absen) = 7, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
        MAX(IF(DAY(tgl_absen) = 8, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
        MAX(IF(DAY(tgl_absen) = 9, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
        MAX(IF(DAY(tgl_absen) = 10, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
        MAX(IF(DAY(tgl_absen) = 11, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
        MAX(IF(DAY(tgl_absen) = 12, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
        MAX(IF(DAY(tgl_absen) = 13, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
        MAX(IF(DAY(tgl_absen) = 14, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
        MAX(IF(DAY(tgl_absen) = 15, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
        MAX(IF(DAY(tgl_absen) = 16, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
        MAX(IF(DAY(tgl_absen) = 17, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
        MAX(IF(DAY(tgl_absen) = 18, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
        MAX(IF(DAY(tgl_absen) = 19, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
        MAX(IF(DAY(tgl_absen) = 20, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
        MAX(IF(DAY(tgl_absen) = 21, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
        MAX(IF(DAY(tgl_absen) = 22, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
        MAX(IF(DAY(tgl_absen) = 23, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
        MAX(IF(DAY(tgl_absen) = 24, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
        MAX(IF(DAY(tgl_absen) = 25, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
        MAX(IF(DAY(tgl_absen) = 26, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
        MAX(IF(DAY(tgl_absen) = 27, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
        MAX(IF(DAY(tgl_absen) = 28, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
        MAX(IF(DAY(tgl_absen) = 29, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
        MAX(IF(DAY(tgl_absen) = 30, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
        MAX(IF(DAY(tgl_absen) = 31, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31')
        ->join('karyawans', 'presensis.nik','=','karyawans.nik')
        ->whereRaw('MONTH(tgl_absen)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_absen)="'.$tahun.'"')
        ->groupByRaw('presensis.nik, nama_lengkap')
        ->get();


        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap','namabulan'));
    }
    public function dataizin(Request $request){

       $query = Izin::query();
       $query->select('izins.id','tgl_izin','izins.nik', 'nama_lengkap', 'status_izin', 'status', 'keterangan_izin');
       $query->join('karyawans', 'izins.nik','=','karyawans.nik');
       if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
       }
       if(!empty($request->nama_lengkap)){
        $query->where('nama_lengkap','like','%'.$request->nama_lengkap.'%');
       }
       if($request->status_konfirmasi === '0' || $request->status_konfirmasi === '1'|| $request->status_konfirmasi === '2' ){
        $query->where('status',$request->status_konfirmasi);
       }
       $query->orderBy('tgl_izin', 'desc');
       $dataizin = $query->paginate(1);
       $dataizin->appends($request->all());
        return view('presensi.dataizin', compact('dataizin'));
    }
    public function konfirmasiizin(Request $request){
        $status_izin = $request->status;
        $id_izin = $request->id_izinform;
        $update = DB::table('izins')
        ->where('id', $id_izin)
        ->update([
            'status' => $status_izin
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Izin Berhasil Disetujui']);
        }else{
            return Redirect::back()->with(['warning'=>'Izin Gagal Disetujui']);
        }
    }
    public function batalapprove($id){
        $update = DB::table('izins')
        ->where('id', $id)
        ->update([
            'status' => 0
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Izin Berhasil Dibatalkan']);
        }else{
            return Redirect::back()->with(['warning'=>'Izin Gagal Dibatalkan']);
        }
    }
}
