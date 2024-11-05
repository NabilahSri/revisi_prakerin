<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormulirApiController extends Controller
{
    public function add(Request $request){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $validator = Validator::make($request->all(),[
                'tanggal' => 'required',
                'status' => 'required',
                'catatan' => 'required',
                'bukti' => 'required',
                'id_siswa' => 'required',
                'id_user' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([$validator->errors()],422);
            }
            $formulir = Kehadiran::create([
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'catatan' => $request->catatan,
                'id_siswa' => $request->id_siswa,
                'id_user' => $request->id_user,
            ]);
            if ($request->hasFile('bukti')) {
                $filename = $request->file('bukti')->storeAs('bukti_formulir', $request->tanggal . '_' . $request->id_siswa . '.' . $request->file('bukti')->getClientOriginalExtension());
                $formulir->bukti = $filename;
                $formulir->save();
            }
            if ($formulir) {
                return response()->json([
                    'success' => true,
                    'formulir' => $formulir,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal tambah formulir'
                ], 409);
            }
        }
    }
}
