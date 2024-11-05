<?php

use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\FormulirApiController;
use App\Http\Controllers\Api\KegiatanApiController;
use App\Http\Controllers\Api\KehadiranApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\PesanApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login',[UserApiController::class,'login']);
Route::get('/logout/{id}',[UserApiController::class,'logout']);
Route::get('/user/{id}',[UserApiController::class,'userId']);
Route::post('/user/editProfil/{id}',[UserApiController::class,'userEditProfil']);
Route::post('/user/editAkun/{id}',[UserApiController::class,'userEditAkun']);
Route::post('/user/aturLokasi/{id}',[UserApiController::class,'aturLokasi']);
Route::post('/user/fcmToken/{id}',[UserApiController::class,'fcmToken']);

Route::get('/dashboard/{id}',[DashboardApiController::class,'show']);

Route::get('/banner/show',[BannerApiController::class,'show']);
Route::get('/banner/show/{id}',[BannerApiController::class,'showId']);

Route::get('/kehadiran/show/{id}',[KehadiranApiController::class,'show']);
Route::get('/kehadiran/show/{id}/{tanggal_awal}/{tanggal_akhir}',[KehadiranApiController::class,'showWithDate']);
Route::post('/kehadiran/masuk',[KehadiranApiController::class,'masuk']);
Route::post('/kehadiran/pulang',[KehadiranApiController::class,'pulang']);

Route::post('/kegiatan/add',[KegiatanApiController::class,'add']);
Route::get('/kegiatan/show/{id}/{tanggal_awal}/{tanggal_akhir}',[KegiatanApiController::class,'show']);

Route::post('/formulir/add',[FormulirApiController::class,'add']);

Route::get('/pesan/show/{id}/{pengirim_pesan}',[PesanApiController::class,'show']);
Route::get('/pesan/showAwal/{id}',[PesanApiController::class,'showAwal']);
Route::post('/pesan/add',[PesanApiController::class,'add']);
