<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanApiController extends Controller
{
    public function show(Request $request,$id,$pengirim_pesan){
        User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $siswa = Siswa::where('id',$id)->first();
            $pesan = Pesan::where(function ($query) use ($siswa, $pengirim_pesan) {
                $query->where('id_penerima', $siswa->id_user)
                      ->where('id_pengirim', $pengirim_pesan);
            })
            ->orWhere(function ($query) use ($siswa, $pengirim_pesan) {
                $query->where('id_penerima', $pengirim_pesan)
                      ->where('id_pengirim', $siswa->id_user);
            })
            ->with(['userPengirim.siswa', 'userPenerima.siswa'])
            ->get();
            return response()->json([
                'success' => true,
                'pesan' => $pesan
            ]);
        }
    }

    public function showAwal(Request $request,$id){
        User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $siswa = Siswa::where('id',$id)->first();
            $pesan = Pesan::where('id_penerima',$siswa->id_user)->with('userPengirim')
                            ->latest()
                            ->get()
                            ->unique('id_pengirim');
            return response()->json([
                'success' => true,
                'pesan' => $pesan
            ]);
        }
    }

    public function add(Request $request){
        User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $pesan = Pesan::create([
                'id_pengirim' => $request->id_pengirim,
                'id_penerima' => $request->id_penerima,
                'pesan' => $request->kirim_pesan,
                'tanggal_kirim' => Carbon::now('Asia/Jakarta')
            ]);
            $user = User::find($request->id_penerima);
            $user->notify(new \App\Notifications\KirimPesanNotification($request->kirim_pesan));
            return response()->json([
                'success' => true,
                'pesan' => $pesan
            ],201);
        }
    }
}
