<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $credential = $request->only('username','password');
        $token = auth()->guard('api')->attempt($credential);
        $user = auth()->guard('api')->user();
        $siswa = Siswa::where('id_user',$user->id)->with('kelas')->first();
        tap(User::where(['username' => $request->username]))->update(['login_token' => $token])->first();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password anda salah'
            ],404);
        }else{
            return response()->json([
                'success' => true,
                'user' => $user,
                'siswa' => $siswa,
                'token' => $token
            ],200);
        }
    }

    public function logout($id){
        User::where('id', $id)->update(['login_token' => null]);
        auth()->guard('api')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil, token telah dihapus'
        ], 200);
    }

    public function userId(Request $request, $id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $user = User::where('id',$id)->first();
            $siswa = Siswa::where('id_user',$user->id)->with('kelas')->first();
            if ($siswa) {
                $data_siswa = [
                    'nisn' => $siswa->nisn,
                    'name' => $siswa->name,
                    'username' => $user->username,
                    'password' => $user->password,
                    'email' => $siswa->email,
                    'telp' => $siswa->telp,
                    'alamat' => $siswa->alamat,
                    'lat' => $siswa->lat,
                    'long' => $siswa->long,
                    'foto' => $siswa->foto ? asset('storage/'.$siswa->foto) : null,
                    'kunci_lokasi' => $siswa->kunci_lokasi,
                    'kelas' => $siswa->kelas->kelas,
                ];
                return response()->json([
                    'success' => true,
                    'user' => $data_siswa
                ],200);
            }else{
                return response()->json(['message' => 'User tidak ditemukan'],404);
            }
        }
    }

    public function userEditProfil(Request $request, $id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()],422);
            }
            $siswa = Siswa::where('id',$id)->first();
            if ($request->hasFile('foto')) {
                $filename = $request->file('foto')->storeAs('foto_siswa', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
                $photopath = $filename;
            }else{
                $photopath = $siswa->foto;
            }
            $siswa -> name = $request->name;
            $siswa -> email = $request->email;
            $siswa -> telp = $request->telp;
            $siswa -> alamat = $request->alamat;
            $siswa -> foto = $photopath;
            $siswa->save();
            if ($siswa) {
                $siswas = Siswa::where('id',$id)->first();
                return response()->json([
                    'success' => true,
                    'siswa' => $siswas,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Gagal ubah data"
                ], 409);
            }
        }
    }

    public function userEditAkun(Request $request, $id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'],404);
            }else{
                if (!empty($request->password)) {
                    $data['password'] = bcrypt($request->password);
                }
                $userUpdate = User::where('id',$id)->update($data);
                if ($userUpdate) {
                    $user = User::where('id',$id)->first();
                    return response()->json([
                        'success' => true,
                        'message' => 'Akun berhasil di ubah',
                        'data' => $user
                    ],200);
                }else{
                    return response()->json(['message' => 'Gagal mengubah data'], 500);
                }
            }
        }
    }

    public function aturLokasi(Request $request,$id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }
        $siswa = Siswa::where('id_user',$id)->first();

        Siswa::where('id',$siswa->id)->update([
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Latlong berhasil tersimpan',
            'data' => $siswa
        ],200);

    }

    public function fcmToken(Request $request,$id){
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }
        $user = User::where('id',$id)->first();

        User::where('id',$user->id)->update([
            'fcm_token' => $request->fcm_token,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Fcm token berhasil tersimpan',
            'data' => $user
        ],200);

    }
}
