<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\LogAktivitas;
use App\Models\Pemonitor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $credential = $request->only('username','password');
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            LogAktivitas::create([
                'username' => $user->username,
                'level' => $user->level,
                'aktivitas' => 'login',
                'waktu' => Carbon::now()->timezone('Asia/Jakarta')
            ]);
            return redirect('/dashboard')->with('success','Berhasil melakukan login');
        }else {
            return redirect()->back()->with('error','Username atau password salah');
        }
    }

    public function logout(){
        $user = Auth::user();
        LogAktivitas::create([
            'username' => $user->username,
            'level' => $user->level,
            'aktivitas' => 'logout',
            'waktu' => Carbon::now()->timezone('Asia/Jakarta')
        ]);
        Auth::logout();
        return redirect('/')->with('success','Berhasil melakukan logout');
    }

    public function show(){
        $data['admin'] = User::where('level','admin')->get();
        return view('pages.admin',$data);
    }

    public function add(Request $request){
        User::create([
            'username' => $request->username,
            'password' => bcrypt('12341234'),
            'level' => 'admin'
        ]);
        return redirect()->back();
    }

    public function delete(Request $request,$id){
        User::where('id',$id)->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function show_akun(Request $request){
        $data['admin'] = User::where('id',Auth::user()->id)->first();
        return view('pages.edit_akun',$data);
    }

    public function edit_akun(Request $request, $id){
        $user = User::find($id);
        $user->username = $request->username;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->level = 'admin';
        $user->save();
        return redirect()->back()->with('success','Data berhasil di edit');
    }

    public function show_profil(Request $request){
        $data['user'] = User::where('id',Auth::user()->id)->first();
        if (Auth::user()->level == 'pemonitor') {
            $data['pengguna'] = Pemonitor::where('id_user',$data['user']->id)->first();
        } elseif (Auth::user()->level == 'industri') {
            $data['pengguna'] = Industri::where('id_user',$data['user']->id)->first();
        }
        return view('pages.edit_profil',$data);
    }

    public function edit_profil(Request $request, $id){
        $user = User::find($id);
        if (Auth::user()->level == 'pemonitor') {
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();

            $user->username = $request->username;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->level = 'pemonitor';
            $user->save();

            $pemonitor->nip = $request->nip;
            $pemonitor->name = $request->name;
            $pemonitor->email = $request->email;
            $pemonitor->telp = $request->telp;
            $pemonitor->alamat = $request->alamat;
            $pemonitor->save();
        }elseif (Auth::user()->level == 'industri') {
            $industri = Industri::where('id_user',$user->id)->first();

            $user->username = $request->username;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->level = 'industri';
            $user->save();

            $industri->name = $request->name;
            $industri->ceo = $request->ceo;
            $industri->email = $request->email;
            $industri->telp = $request->telp;
            $industri->alamat = $request->alamat;
            $industri->lat = $request->lat;
            $industri->long = $request->long;
            $industri->save();
        }
        return redirect()->back()->with('success','Data berhasil di edit');
    }
}
