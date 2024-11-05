<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\TokenMasuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenMasukController extends Controller
{
    public function show(){
        $data['token_masuk'] = TokenMasuk::all();
        return view('pages.token_masuk',$data);
    }

    public function add(){
        $carbon = Carbon::now('Asia/Jakarta')->addMinute(30);
        $token_length = 5;
        $token = '';
        for ($i=0; $i < $token_length; $i++) {
            $token .= mt_rand(0,9);
        }
        $user = User::where('id',Auth::user()->id)->first();
        $industri = Industri::where('id_user',$user->id)->first();
        TokenMasuk::create([
            'token' => $token,
            'kadaluarsa_pada' => $carbon,
            'id_industri' => $industri->id
        ]);
        return redirect('token/masuk');
    }
}
