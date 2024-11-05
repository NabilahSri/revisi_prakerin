<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\KategoriPenilaian;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function show(){
        if (Auth::user()->level == 'industri') {
            $user = User::where('id',Auth::user()->id)->first();
            $industri = Industri::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_industri',$industri->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('user')->with('kelas')->get();
            $data['kategori_penilaian'] = KategoriPenilaian::all();
        } elseif (Auth::user()->level == 'admin') {
            $data['siswa'] = Siswa::with('user')->with('kelas')->get();
        }else{
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('user')->with('kelas')->get();
        }


        return view('pages.penilaian',$data);
    }

    public function add(Request $request){
        $user = auth()->user()->id;
        $industri = Industri::where('id_user',$user)->first();
        $nilai = $request->input('nilai');
        $id_kategori_penilaian = $request->input('id_kategori_penilaian');
        $saran = $request->input('saran');
        foreach ($id_kategori_penilaian as $id_kategori) {
            Penilaian::create([
                'id_siswa' => $request->id_siswa,
                'id_industri' => $industri->id,
                'id_kategori_penilaian' => $id_kategori,
                'nilai' => $nilai[$id_kategori],
                'saran' => $saran,
            ]);
        }
        return redirect()->back()->with('success','Penilaian berhasil disimpan');
    }

    public function edit(Request $request, $id){
        $user = auth()->user()->id;
        // $siswa = Siswa::where('id_user',$user->id)->first();
        $industri = Industri::where('id_user',$user)->first();
        $nilai = $request->input('nilai');
        $id_kategori_penilaian = $request->input('id_kategori_penilaian');
        $saran = $request->input('saran');
        $pesan = Penilaian::where('id_siswa',$request->id_siswa)->delete();
        foreach ($id_kategori_penilaian as $id_kategori) {
            Penilaian::create([
                'id_siswa' => $request->id_siswa,
                'id_industri' => $industri->id,
                'id_kategori_penilaian' => $id_kategori,
                'nilai' => $nilai[$id_kategori],
                'saran' => $saran,
            ]);
        }
        return redirect()->back()->with('success','Penilaian berhasil diupdate');
    }
}
