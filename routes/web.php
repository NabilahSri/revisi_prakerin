<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\KategoriPenilaianController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\LaporanKehadiranController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PemonitorController;
use App\Http\Controllers\PengaturanAplikasiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TokenKeluarController;
use App\Http\Controllers\TokenMasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebTokenController;
use Illuminate\Support\Facades\Route;





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

Route::get('/', function () {
    return view('pages.login');
});

Route::get('/edit-akun',[UserController::class,'show_akun']);
Route::post('/edit-akun/{id}',[UserController::class,'edit_akun']);

Route::get('/edit-profil',[UserController::class,'show_profil']);
Route::post('/edit-profil/{id}',[UserController::class,'edit_profil']);

Route::post('/login',[UserController::class,'login']);

Route::get('/logout',[UserController::class,'logout']);

Route::get('/dashboard',[DashboardController::class,'show']);

Route::get('/kelas',[KelasController::class,'show']);
Route::post('/kelas/add',[KelasController::class,'add'])->middleware('log.create');
Route::get('/kelas/delete/{id}',[KelasController::class,'delete'])->middleware('log.delete');
Route::post('/kelas/import-excel',[KelasController::class,'import_excel']);

Route::get('/pengguna/admin',[UserController::class,'show']);
Route::post('/pengguna/admin/add',[UserController::class,'add'])->middleware('log.create');
Route::get('/pengguna/admin/delete/{id}',[UserController::class,'delete'])->middleware('log.delete');

Route::get('/pengguna/siswa',[SiswaController::class,'show']);
Route::post('/pengguna/siswa/add',[SiswaController::class,'add'])->middleware('log.create');
Route::get('/pengguna/siswa/delete/{id}',[SiswaController::class,'delete'])->middleware('log.delete');
Route::get('/pengguna/siswa/logout/{id}',[SiswaController::class,'logout']);
Route::post('/pengguna/siswa/edit/{id}',[SiswaController::class,'edit'])->middleware('log.edit');
Route::post('/pengguna/siswa/import-excel',[SiswaController::class,'import_excel']);
Route::post('/pengguna/siswa/update-kunci-lokasi/{id}',[SiswaController::class,'update_kunci_lokasi'])->middleware('log.edit');

Route::get('/pengguna/pemonitor',[PemonitorController::class,'show']);
Route::post('/pengguna/pemonitor/add',[PemonitorController::class,'add'])->middleware('log.create');
Route::get('/pengguna/pemonitor/delete/{id}',[PemonitorController::class,'delete'])->middleware('log.delete');
Route::post('/pengguna/pemonitor/edit/{id}',[PemonitorController::class,'edit'])->middleware('log.edit');
Route::post('/pengguna/pemonitor/import-excel',[PemonitorController::class,'import_excel']);

Route::get('/pengguna/industri',[IndustriController::class,'show']);
Route::post('/pengguna/industri/add',[IndustriController::class,'add'])->middleware('log.create');
Route::get('/pengguna/industri/delete/{id}',[IndustriController::class,'delete'])->middleware('log.delete');
Route::post('/pengguna/industri/edit/{id}',[IndustriController::class,'edit'])->middleware('log.edit');
Route::post('/pengguna/industri/import-excel',[IndustriController::class,'import_excel']);

Route::get('/monitoring',[MonitoringController::class,'show']);
Route::post('/monitoring/add',[MonitoringController::class,'add'])->middleware('log.create');
Route::post('/monitoring/edit/{id}',[MonitoringController::class,'edit'])->middleware('log.edit');
Route::get('/monitoring/delete/{id}',[MonitoringController::class,'delete'])->middleware('log.delete');
Route::post('/monitoring/import-excel',[MonitoringController::class,'import_excel']);

Route::get('/banner',[BannerController::class,'show']);
Route::post('/banner/add',[BannerController::class,'add'])->middleware('log.create');
Route::get('/banner/delete/{id}',[BannerController::class,'delete'])->middleware('log.delete');
Route::post('/banner/edit/{id}',[BannerController::class,'edit'])->middleware('log.edit');

Route::get('/kehadiran',[KehadiranController::class,'show']);
Route::post('/kehadiran/add',[KehadiranController::class,'add'])->middleware('log.create');
Route::get('/kehadiran/export_excel',[KehadiranController::class,'export_excel']);

Route::get('/kegiatan',[KegiatanController::class,'show']);
Route::post('/kegiatan/add',[KegiatanController::class,'add']);
Route::post('/kegiatan/edit/{id}',[KegiatanController::class,'edit']);
Route::get('/kegiatan/delete/{id}',[KegiatanController::class,'delete']);

Route::get('/laporan/kehadiran',[LaporanKehadiranController::class,'show']);
Route::post('/laporan/kehadiran',[LaporanKehadiranController::class,'show']);
Route::post('/laporan/kehadiran/export_excel',[LaporanKehadiranController::class,'export_excel']);

Route::get('/laporan/kegiatan',[LaporanKegiatanController::class,'show']);
Route::post('/laporan/kegiatan',[LaporanKegiatanController::class,'show']);
Route::post('/laporan/kegiatan/export_excel',[LaporanKegiatanController::class,'export_excel']);

Route::get('/log_aktivitas',[LogAktivitasController::class,'show']);

Route::get('/pengaturan_aplikasi',[PengaturanAplikasiController::class,'show']);
Route::get('/pengaturan_aplikasi/edit/{id}',[PengaturanAplikasiController::class,'edit'])->middleware('log.edit');

Route::get('/token/masuk',[TokenMasukController::class,'show']);
Route::post('/token/masuk/add',[TokenMasukController::class,'add'])->middleware('log.create');

Route::get('/token/keluar',[TokenKeluarController::class,'show']);
Route::post('/token/keluar/add',[TokenKeluarController::class,'add'])->middleware('log.create');

Route::get('/pesan',[PesanController::class,'show']);
Route::post('/pesan/{id}',[PesanController::class,'store']);

Route::post('/web-token',WebTokenController::class);

Route::get('/kategori-penilaian',[KategoriPenilaianController::class,'show']);
Route::post('/kategori-penilaian/add',[KategoriPenilaianController::class,'add'])->middleware('log.create');
Route::get('/kategori-penilaian/delete/{id}',[KategoriPenilaianController::class,'delete'])->middleware('log.delete');

Route::get('/penilaian',[PenilaianController::class,'show']);
Route::post('/penilaian',[PenilaianController::class,'add']);
Route::post('/penilaian/{id}',[PenilaianController::class,'edit']);








