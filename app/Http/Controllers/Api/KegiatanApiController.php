<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KegiatanApiController extends Controller
{
    public function add(Request $request){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $validator = Validator::make($request->all(),[
                'deskripsi' => 'required',
                'foto' => 'required',
                'durasi' => 'required',
                'id_kehadiran' => 'required',
                'id_siswa' => 'required',
                'id_kelas' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()],422);
            }
            $kegiatan = Kegiatan::create([
                'deskripsi' => $request->deskripsi,
                'durasi' => $request->durasi,
                'id_kehadiran' => $request->id_kehadiran,
                'id_siswa' => $request->id_siswa,
                'id_kelas' => $request->id_kelas,
            ]);
            if ($request->hasFile('foto')) {
                $filename = $request->file('foto')->storeAs('foto_kegiatan', $request->id_kehadiran . '_' . $request->id_siswa . '.' . $request->file('foto')->getClientOriginalExtension());
                $kegiatan->foto = $filename;
                $kegiatan->save();
            }
            if ($kegiatan) {
                return response()->json([
                    'success' => true,
                    'kegiatan' => $kegiatan,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal tambah kegiatan'
                ], 409);
            }
        }
    }

    public function show(Request $request,$id,$tanggal_awal, $tanggal_akhir){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        } else {
            // Cari data siswa yang sesuai
            $siswa = Siswa::where('id', $id)->first();

            // Cek apakah siswa ditemukan
            if (!$siswa) {
                return response()->json(['message' => 'Siswa not found'], 404);
            }

            // Cari data kehadiran berdasarkan tanggal dan siswa
            $kehadiran = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                                ->where('id_siswa', $siswa->id)
                                ->get();

            // Jika tidak ada kehadiran ditemukan
            if ($kehadiran->isEmpty()) {
                return response()->json(['message' => 'No attendance found'], 404);
            }

            // Ambil data kegiatan berdasarkan kehadiran
            $kegiatan = Kegiatan::whereIn('id_kehadiran', $kehadiran->pluck('id'))->orderBy('id', 'desc')->get();

            // Gabungkan kegiatan dengan tanggal dari kehadiran
            $kegiatanWithTanggal = $kegiatan->map(function($kegiatans) use ($kehadiran) {
                // Cari tanggal dari kehadiran sesuai dengan id_kehadiran
                $tanggalKehadiran = $kehadiran->where('id', $kegiatans->id_kehadiran)->first()->tanggal;

                // Ubah durasi dari menit ke format "1 jam 20 menit"
                $durasiMenit = $kegiatans->durasi;
                $hours = floor($durasiMenit / 60); // Hitung jumlah jam
                $minutes = $durasiMenit % 60;      // Hitung sisa menit

                // Format durasi dalam bentuk "x jam y menit"
                if ($hours > 0 && $minutes > 0) {
                    $formattedDurasi = "$hours jam $minutes menit";
                } elseif ($hours > 0) {
                    $formattedDurasi = "$hours jam";
                } else {
                    $formattedDurasi = "$minutes menit";
                }

                // Format data kegiatan beserta tanggal kehadiran
                return [
                    'id' => $kegiatans->id,
                    'deskripsi' => $kegiatans->deskripsi,
                    'durasi' => $formattedDurasi,
                    'foto' => $kegiatans->foto ? asset('storage/' . $kegiatans->foto) : null,
                    'tanggal' => $tanggalKehadiran // tambahkan tanggal kehadiran
                ];
            });

            return response()->json(['kegiatan' => $kegiatanWithTanggal], 200);
        }
    }
}
