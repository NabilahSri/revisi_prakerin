<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Monitoring;
use App\Models\Siswa;
use App\Models\TokenKeluar;
use App\Models\TokenMasuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet  = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('miles','feet','yards','kilometers','meters');
}

class KehadiranApiController extends Controller
{
    public function show(Request $request, $id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $siswa = Siswa::where('id',$id)->first();
            $kehadiran = Kehadiran::where('id_siswa',$siswa->id)->orderBy('tanggal','desc')->latest()->take(5)->get();
            foreach ($kehadiran as $kehadirans) {
                if ($kehadirans->bukti) {
                    $kehadirans->bukti = asset('storage/'.$kehadirans->bukti);
                }
            }
            $kehadiran->transform(function ($item) {
                $item->jumlah_kegiatan = Kegiatan::where('id_kehadiran', $item->id)->count();
                return $item;
            });
            return response()->json([
                'kehadiran' => $kehadiran
            ],200);
        }
    }

    public function showWithDate(Request $request,$id,$tanggal_awal,$tanggal_akhir){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }else{
            $siswa = Siswa::where('id', $id)->first();

            if (!$siswa) {
                return response()->json(['message' => 'Siswa not found'], 404);
            }

            $kehadiran = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                                ->where('id_siswa', $siswa->id)
                                ->orderBy('tanggal','desc')
                                ->get();

            if ($kehadiran->isEmpty()) {
                return response()->json(['message' => 'No attendance found'], 404);
            }

            foreach ($kehadiran as $kehadirans) {
                if ($kehadirans->bukti) {
                    $kehadirans->bukti = asset('storage/'.$kehadirans->bukti);
                }
            }

            $kehadiran->transform(function ($item) {
                $item->jumlah_kegiatan = Kegiatan::where('id_kehadiran', $item->id)->count();
                return $item;
            });
            return response()->json([
                'kehadiran' => $kehadiran
            ],200);
        }
    }

    public function masuk(Request $request){
        $user = auth()->guard('api')->user();
        $siswa = Siswa::where('id_user',$user->id)->first();
        // $monitoring = Monitoring::where('id_siswa',$siswa->id)->first();
        // $industri = Industri::where('id',$monitoring->id_industri)->first();
        $point1 = ([
            "lat" => $siswa->lat,
            "long" => $siswa->long,
        ]);
        $point2 = ([
            "lat" => $request->lat,
            "long" => $request->long,
        ]);
        $distance = getDistanceBetweenPoints($point1['lat'],$point1['long'],$point2['lat'],$point2['long']);
        $distances = $distance['meters'];
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $mode = $request->mode;
            $tokenMasuk = TokenMasuk::orderBy('created_at','desc')->first();
            $waktu = Carbon::now('Asia/Jakarta');
            if ($mode == "Lokasi") {
                if ($distances>1000) {
                    return response()->json([
                        'message' => 'anda berada di luar zona kehadiran',
                        'lat' => $point2['lat'],
                        'long' => $point2['long'],
                        'distance' => $distances
                    ],403);
                }
            }
            if($mode == "Token") {
                if ($request->token_masuk != $tokenMasuk->token) {
                    return response()->json(['message' => 'Token tidak sesuai'],401);
                }
                if ($waktu > $tokenMasuk->kadaluarsa_pada) {
                    return response()->json(['message' => 'Token kadaluarsa'],404);
                }
            }
            $validator = Validator::make($request->all(),[
                'tanggal' => 'required',
                'status' => 'required',
                'id_siswa' => 'required',
                'id_user' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $kehadiran = Kehadiran::create([
                'tanggal' => $request->tanggal,
                'jam_masuk' => $request->jam_masuk,
                'status' => $request->status,
                'id_siswa' => $request->id_siswa,
                'id_user' => $request->id_user,
            ]);
            if ($kehadiran) {
                return response()->json([
                    'success' => true,
                    'kehadiran' => $kehadiran,
                    'distances' => $distances,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Gagal melakukan kehadiran"
                ], 409);
            }

        }
    }

    public function pulang(Request $request){
        $user = auth()->guard('api')->user();
        $siswa = Siswa::where('id_user',$user->id)->first();
        // $monitoring = Monitoring::where('id_siswa',$siswa->id)->first();
        // $industri = Industri::where('id',$monitoring->id_industri)->first();
        $point1 = ([
            "lat" => $siswa->lat,
            "long" => $siswa->long,
        ]);
        $point2 = ([
            "lat" => $request->lat,
            "long" => $request->long,
        ]);
        $distance = getDistanceBetweenPoints($point1['lat'],$point1['long'],$point2['lat'],$point2['long']);
        $distances = $distance['meters'];
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $mode = $request->mode;
            $token_keluar = TokenKeluar::orderBy('created_at','desc')->first();
            $waktu = Carbon::now('Asia/Jakarta');
            if ($mode == "Lokasi") {
                if ($distances>1000) {
                    return response()->json([
                        'message' => 'anda berada di luar zona kehadiran',
                        'lat' => $point2['lat'],
                        'long' => $point2['long'],
                        'distance' => $distances
                    ],403);
                }
            }
            if($mode == "Token") {
                if ($request->token_keluar != $token_keluar->token) {
                    return response()->json(['message' => 'Token tidak sesuai'],401);
                }
                if ($waktu > $token_keluar->kadaluarsa_pada) {
                    return response()->json(['message' => 'Token kadaluarsa'],404);
                }
            }
            $validator = Validator::make($request->all(),[
                'jam_pulang' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $kehadiran = Kehadiran::where('id_siswa',$siswa->id)->where('tanggal',$request->tanggal)->update(['jam_pulang' => $request->jam_pulang]);
            if ($kehadiran) {
                return response()->json([
                    'success' => true,
                    'kehadiran' => $kehadiran,
                    'distances' => $distances,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Gagal melakukan kehadiran"
                ], 409);
            }
        }
    }
}
