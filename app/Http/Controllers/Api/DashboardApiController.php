<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function show(Request $request, $id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $user = User::where('id',$id)->first();
            $siswa = Siswa::where('id_user',$user->id)->with('kelas')->first();
            $hadir = Kehadiran::where('id_siswa',$siswa->id)->where('status','hadir')->count();
            $izin = Kehadiran::where('id_siswa',$siswa->id)->where('status','izin')->count();
            $sakit = Kehadiran::where('id_siswa',$siswa->id)->where('status','sakit')->count();
            $kegiatan = Kegiatan::where('id_siswa',$siswa->id)->get();
            $jumlah_menit = $kegiatan->sum('durasi');
            $jam = floor($jumlah_menit / 60);
            $menit = $jumlah_menit % 60;
            if ($siswa) {
                $data_siswa = [
                    'name' => $siswa->name,
                    'kelas' => $siswa->kelas->kelas,
                    'foto' => $siswa->foto ? asset('storage/'.$siswa->foto) : null
                ];

                return response()->json([
                    'siswa' => $data_siswa,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'total_jam_kerja' => [
                        'jam' => $jam,
                        'menit' => $menit
                    ]
                ],200);
            }else{
                return response()->json(['message' => 'User tidak ditemukan'],404);
            }
        }
    }
}
