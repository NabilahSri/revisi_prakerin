<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Pesan;
use App\Models\Siswa;
use App\Models\User;
use App\Notifications\KirimPesanNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function show(){
        if (auth()->user()->level == 'admin') {
            $data['monitoring'] = Monitoring::with('pemonitor')->with('industri')->with('siswa.kelas')->get();
        }elseif (auth()->user()->level == 'pemonitor') {
            $user = auth()->user()->id;
            $pemonitor = Pemonitor::where('id_user',$user)->get();
            $data['monitoring'] = Monitoring::where('id_pemonitor',$pemonitor->pluck('id'))->with('pemonitor')->with('industri')->with('siswa.kelas')->get();
        }
        return view('pages.pesan', $data);
    }

    // public function store(Request $request,$id){
    //     Pesan::create([
    //         'id_pengirim' => auth()->user()->id,
    //         'id_penerima' => $id,
    //         'pesan' => $request->pesan,
    //         'tanggal_kirim' => Carbon::now('Asia/Jakarta')
    //     ]);
    //     $user = User::where('id',$id)->first();
    //     $user->notify(new \App\Notifications\KirimPesanNotification($request->pesan));
    //     return redirect()->back()->with('success','Pesan berhasil di kirim dan di simpan');

    // }

    public function store(Request $request, $id)
    {
        $pesan = Pesan::create([
            'id_pengirim' => auth()->user()->id,
            'id_penerima' => $id,
            'pesan' => $request->pesan,
            'tanggal_kirim' => Carbon::now('Asia/Jakarta')
        ]);

        $user = User::find($id);
        $user->notify(new \App\Notifications\KirimPesanNotification($request->pesan));

        // Mengembalikan response JSON agar bisa dihandle oleh AJAX
        return response()->json([
            'pesan' => $pesan->pesan,
            'tanggal_kirim' => Carbon::parse($pesan->tanggal_kirim)->translatedFormat('l, d-m-Y H:i'),
            'nama_penerima' => $user->siswa->name
        ]);
    }
}
