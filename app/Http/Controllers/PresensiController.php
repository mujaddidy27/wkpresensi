<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


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
        $kode_shift = Auth::guard('karyawan')->user()->kode_shift;
        $cek = DB::table('presensis')->where('tgl_absen', $hariini)->where('nik', $nik)->count();
        $kode_cab = Auth::guard('karyawan')->user()->kode_cab;
        $lokasi_kantor = DB::table('cabangs')->where('kode_cab', $kode_cab)->first();
        $shift = DB::table('jams')->get();
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $shift_karyawan = DB::table('jams')->where('kode_shift', $kode_shift)->first();
        $title = "Absen";
        return view('presensi.create', compact('title','cek', 'lokasi_kantor', 'shift', 'karyawan', 'shift_karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function pilihshift(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_shift = Auth::guard('karyawan')->user()->kode_shift;
        $shift = $request->kode_shift;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $jams = DB::table('jams')->where('kode_shift', $kode_shift)->first();
        $nama_shift = $jams->nama_shift;
        // dd($nama_shift);
        $notif = "Anda Saat Ini Berada di Shift $nama_shift ! ";

        if (empty($kode_shift)) {
            try {
                $data = [
                    'kode_shift' => $shift,
                ];
                $update = DB::table('karyawans')->where('nik', $nik)->update($data);
                if ($update) {
                    return Redirect::back()->with(['success' => 'Shift Berhasil Dipilih !']);
                }
            } catch (\Throwable $th) {
                return Redirect::back()->with(['warning' => 'Shift Gagal Dipilih !']);
            }
        }

        if ($kode_shift != $shift) {
            try {
                $data = [
                    'kode_shift' => $shift,
                ];
                $update = DB::table('karyawans')->where('nik', $nik)->update($data);
                if ($update) {
                    return Redirect::back()->with(['success' => 'Shift Berhasil Dipilih !']);
                }
            } catch (\Throwable $th) {
                return Redirect::back()->with(['warning' => 'Shift Gagal Dipilih !']);
            }
        }
        if ($kode_shift == $shift) {
            try {
                return Redirect::back()->with(['success' => $notif]);
            } catch (\Throwable $th) {
                return Redirect::back()->with(['warning' => $notif]);
            }
        }

    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_cab = Auth::guard('karyawan')->user()->kode_cab;
        $kode_shift = Auth::guard('karyawan')->user()->kode_shift;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi_kantor = DB::table('cabangs')->where('kode_cab', $kode_cab)->first();
        $jam_kerja = DB::table('jams')->where('kode_shift', $kode_shift)->first();
        $lok = explode(",", $lokasi_kantor->lokasi_cab);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $cek = DB::table('presensis')->where('tgl_absen', $tgl_presensi)->where('nik', $nik)->count();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formateName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formateName . ".png";
        $file = $folderPath . $fileName;
        $jarak_batas = $lokasi_kantor->radius;

        if ($radius > $jarak_batas) {
            echo "error|Maaf, Anda berada diluar kantor. Jarak anda $radius meter dari kantor|luar";
        } else {
            if ($cek > 0) {
                if ($jam < $jam_kerja->jam_pulang) {
                    echo "error|Maaf, Belum Waktunya Jam Pulang !|out";
                } else {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi,
                    ];
                    $update = DB::table('presensis')->where('tgl_absen', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "success|Terimakasih, Hati-hati di jalan !|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Absen gagal, Silahkan hub IT Mas Didy|out";
                    }
                }

            } else {
                if ($jam < $jam_kerja->awal_jam_masuk) {
                    echo "error|Maaf, Belum Waktunya Absen !|in";
                } elseif ($jam > $jam_kerja->akhir_jam_masuk) {
                    echo "error|Maaf, Waktu Absen Masuk Telah Berakhir !|in";
                } else {

                    $data = [
                        'nik' => $nik,
                        'tgl_absen' => $tgl_presensi,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                        'kode_shift' => $kode_shift,
                    ];
                    $simpan = DB::table('presensis')->insert($data);
                    if ($simpan) {
                        echo "success|Absen berhasil, Selamat bekerja !|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Absen gagal, Silahkan hub IT Mas Didy|in";
                    }
                }

            }

        }
    }

    //Menghitung Jarak
    public function distance($lat1, $lon1, $lat2, $lon2)
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

    //profile
    public function profile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $title = "Profile";
        return view('presensi.profile', compact('title','karyawan'));
    }
    //editprofile
    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $title = "Profile";
        return view('presensi.editprofile', compact('title','karyawan'));
    }
    //updateprofile
    // public function updateprofile(Request $request)
    // {
    //     $nik = Auth::guard('karyawan')->user()->nik;
    //     $nama = $request->nama_lengkap;
    //     $no_hp = $request->no_hp;
    //     $password = $request->password;
    //     $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
    //     $upfoto = $request->hasFile('foto');
    //     $old_foto = $karyawan->foto;
    //     if ($request->hasFile('foto')) {
    //         $foto = $nik . "." . $request->hasFile('foto')->getClientOriginalExtension();
    //     } else {
    //         $foto = $old_foto;
    //     }

    //     if (empty($password)) {
    //         $data = [
    //             'nama_lengkap' => $nama,
    //             'no_hp' => $no_hp,
    //             'foto' => $foto,
    //         ];

    //     } else {
    //         $data = [
    //             'nama_lengkap' => $nama,
    //             'no_hp' => $no_hp,
    //             'foto' => $foto,
    //             'password' => Hash::make($password),
    //         ];
    //     }

    //     $update = DB::table('karyawans')->where('nik', $nik)->update($data);

    //     if ($update) {
    //         if ($request->hasFile('foto')) {
    //             $folderPath = "public/uploads/karyawan/";
    //             $folderPathOld = "public/uploads/karyawan/" . $karyawan->foto;
    //             Storage::delete($folderPathOld);
    //             $request->file('foto')->storeAs($folderPath, $foto);
    //         }
    //         return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !']);
    //     } else {
    //         return Redirect::back()->with(['error' => 'Data gagal diupdate']);
    //     }

    // }
    public function uprofile($nik, Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make('1234');
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        $old_foto = $karyawan->foto;
        $new = $request->hasFile('imgprofile');

        if ($request->hasFile('imgprofile')) {
            $foto = $nik . "." . $request->file('imgprofile')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
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
    //history
    public function history()
    {
        $title = "History Absen";
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.history', compact('title','namabulan'));
    }
    //gethistory
    public function gethistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('presensis')
            ->whereRaw('MONTH(tgl_absen)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absen)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_absen')
            ->get();
        $title = "History Absen";
        return view('presensi.gethistory', compact('title','history'));
    }

    //izin
    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('izins')->where('nik', $nik)->get();
        $title = "Izin";
        return view('presensi.izin', compact('title','dataizin'));
    }
    //buatizin
    public function buatizin()
    {
        $title = "Creat Izin";
        return view('presensi.buatizin', compact('title'));
    }
    //ajukanizin
    public function ajukanizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status_izin' => $status,
            'keterangan_izin' => $keterangan,
        ];

        $simpan = DB::table('izins')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/presensi/buatizin')->with(['success' => 'Data Gagal Disimpan']);
        }
    }

    // monitoring
    public function monitoring()
    {
        $title = "Monitoring";
        return view('presensi.monitoring', compact('title'));
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')
            ->select('presensis.*', 'nama_lengkap', 'nama', 'nama_shift', 'jam_masuk')
            ->leftJoin('jams', 'presensis.kode_shift', '=', 'jams.kode_shift')
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->join('departemens', 'karyawans.kode_dpt', '=', 'departemens.kode')
            ->where('tgl_absen', $tanggal)
            ->get();
        // $kode_shift = $presensi->kode_shift;
        // // dd($kode_shift);
        // $shift_karyawan = DB::table('jams')->where('kode_shift', $kode_shift)->first();
        $title = "Presensi";
        return view('presensi.getpresensi', compact('title','presensi'));
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensis')->where('presensis.id', $id)
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->first();
        $title = "ShowMap";
        return view('presensi.showmap', compact('title','presensi'));
    }

    public function laporanpresensi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawans')->orderBy('nama_lengkap')->get();
        $title = "Report";
        return view('presensi.laporanpresensi', compact('title','namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->karyawan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawans')->where('nik', $nik)
            ->join('departemens', 'karyawans.kode_dpt', '=', 'departemens.kode')
            ->first();
        $presensi = DB::table('presensis')
            ->leftJoin('jams', 'presensis.kode_shift', '=', 'jams.kode_shift')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_absen)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absen)="' . $tahun . '"')
            ->get();
        if (isset($_POST['exporttoexcel'])) {
            $time = date("d-m-Y H:i:s");
            //fungsi header mengirimkan raw data excel
            header("Content-type: application/vdn-ms-excel");
            //mendefinisika nama file export "Hasil-export.xls"
            header("Content-Disposition: attachment; filename= Laporan Absen Karyawan $time.xls");
            return view('presensi.cetaklaporantoexcel', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
        }
        $title = "Report";
        return view('presensi.cetaklaporan', compact('title','bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekappresensi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawans')->orderBy('nama_lengkap')->get();
        $title = "Report";
        return view('presensi.rekappresensi', compact('title','namabulan', 'karyawan'));
    }
    public function cetakrekap(Request $request)
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensis')
            ->selectRaw('presensis.nik,nama_lengkap,jam_masuk,jam_pulang,
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
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->leftJoin('jams', 'presensis.kode_shift', '=', 'jams.kode_shift')
            ->whereRaw('MONTH(tgl_absen)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absen)="' . $tahun . '"')
            ->groupByRaw('presensis.nik, nama_lengkap, jam_masuk, jam_pulang')
            ->get();

        if (isset($_POST['exporttoexcel'])) {
            $time = date("d-m-Y H:i:s");
            //fungsi header mengirimkan raw data excel
            header("Content-type: application/vdn-ms-excel");
            //mendefinisika nama file export "Hasil-export.xls"
            header("Content-Disposition: attachment; filename= Rekap Absen Karyawan $time.xls");
        }
        $title = "Report";
        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap', 'namabulan'));
    }
    public function dataizin(Request $request)
    {

        $query = Izin::query();
        $query->select('izins.id', 'tgl_izin', 'izins.nik', 'nama_lengkap', 'status_izin', 'status', 'keterangan_izin');
        $query->join('karyawans', 'izins.nik', '=', 'karyawans.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_konfirmasi === '0' || $request->status_konfirmasi === '1' || $request->status_konfirmasi === '2') {
            $query->where('status', $request->status_konfirmasi);
        }
        $query->orderBy('tgl_izin', 'desc');
        $dataizin = $query->paginate(15);
        $dataizin->appends($request->all());
        $title = "Data Izin";
        return view('presensi.dataizin', compact('title','dataizin'));
    }
    public function konfirmasiizin(Request $request)
    {
        $status_izin = $request->status;
        $id_izin = $request->id_izinform;
        $update = DB::table('izins')
            ->where('id', $id_izin)
            ->update([
                'status' => $status_izin,
            ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Izin Berhasil Disetujui']);
        } else {
            return Redirect::back()->with(['warning' => 'Izin Gagal Disetujui']);
        }
    }

    public function batalapprove($id)
    {
        $update = DB::table('izins')
            ->where('id', $id)
            ->update([
                'status' => 0,
            ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Izin Berhasil Dibatalkan']);
        } else {
            return Redirect::back()->with(['warning' => 'Izin Gagal Dibatalkan']);
        }
    }

    public function notif()
    {
        $hariini = date('Y-m-d');
        $izins = DB::table('izins')->where('tgl_izin', $hariini)
            ->join('karyawans', 'izins.nik', '=', 'karyawans.nik')
            ->get();
        $presensis = DB::table('presensis')->where('tgl_absen', $hariini)->get();
        return view('layout.admin.header', compact('bulan', 'tahun', 'rekap', 'namabulan'));

    }
}
