<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        $title = 'login';
        return view('auth.login', compact('title'));
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        $title = 'login';
        return view('auth.loginadmin', compact('title'));
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('logout');

    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);
    Route::post('/presensi/pilihshift', [PresensiController::class, 'pilihshift']);
    //profile
    Route::get('/profile', [PresensiController::class, 'profile']);
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'uprofile']);
    //history
    Route::get('/presensi/history', [PresensiController::class, 'history']);
    Route::post('/gethistory', [PresensiController::class, 'gethistory']);
    //izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/ajukanizin', [PresensiController::class, 'ajukanizin']);

});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/logoutadmin', [AuthController::class, 'logoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    // Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);
    //Departemen
    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode}/delete', [DepartemenController::class, 'delete']);
    //Monitoring Presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/presensi/laporanpresensi', [PresensiController::class, 'laporanpresensi']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekappresensi', [PresensiController::class, 'rekappresensi']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
    Route::get('/presensi/dataizin', [PresensiController::class, 'dataizin']);
    Route::post('/presensi/konfirmasiizin', [PresensiController::class, 'konfirmasiizin']);
    Route::get('/presensi/{id}/batalapprove', [PresensiController::class, 'batalapprove']);

    //Cabang
    Route::get('/kantorcabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);
    Route::post('/cabang/{kode_cab}/delete', [CabangController::class, 'delete']);
    Route::post('/cabang/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/{kode_cab}/update', [CabangController::class, 'update']);

    //konfigurasi
    Route::get('/konfigurasi/jamkerja', [KonfigurasiController::class, 'jamkerja']);
    Route::post('/konfigurasi/store', [KonfigurasiController::class, 'store']);
    Route::post('/konfigurasi/{kode_shift}/delete', [KonfigurasiController::class, 'delete']);
    Route::post('/konfigurasi/editjam', [KonfigurasiController::class, 'editjam']);
    Route::post('/konfigurasi/{kode_shift}/update', [KonfigurasiController::class, 'update']);
    Route::get('/konfigurasi/{nik}/setjamkerja', [KonfigurasiController::class, 'setjamkerja']);

    //Pengguna
    Route::get('/users/pengguna', [KaryawanController::class, 'pengguna']);
    Route::post('/users/store', [KaryawanController::class, 'tambahpengguna']);
    Route::post('/users/{nik}/delete', [KaryawanController::class, 'deleteuser']);

});

Route::get('/createrolepermission', function () {

    try {
        $role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);
        echo "sukses";
    } catch (\Exception $th) {
        echo "error";
    }

});

Route::get('/give-user-role', function () {

    try {
        $user = User::findorfail(1);
        $user->assignRole('administrator');
        echo "sukses";
    } catch (\Throwable $th) {
        echo "error";
    }

});
