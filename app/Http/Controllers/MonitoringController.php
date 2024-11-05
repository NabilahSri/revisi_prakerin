<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function show(){
        $data['pemonitor'] = Pemonitor::all();
        $data['kelas'] = Kelas::all();
        $data['siswa'] = Siswa::with('kelas')->get();
        $data['industri'] = Industri::all();
        if (Auth::user()->level == 'admin') {
            $data['monitoring'] = Monitoring::with('pemonitor')->with('industri')->groupBy('id_industri')->get();
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $data['monitoring'] = Monitoring::where('id_pemonitor',$pemonitor->id)->groupBy('id_industri')->get();
        }
        return view('pages.monitoring', $data);
    }

    public function add(Request $request){
        foreach ($request->id_siswa as $id_siswa) {
            Monitoring::create([
                'id_pemonitor' => $request->id_pemonitor,
                'id_industri' => $request->id_industri,
                'id_siswa' => $id_siswa,
            ]);
        }
        return redirect()->back()->with('success','Data berhasil ditambahkan');
    }

    public function delete(Request $request ,$id){
        Monitoring::where('id_industri', $id)->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function edit(Request $request,$id){
        Monitoring::where('id_industri', $id)->delete();

       foreach ($request->id_siswa as $id_siswa) {
            Monitoring::create([
                'id_pemonitor' => $request->id_pemonitor,
                'id_industri' => $request->id_industri,
                'id_siswa' => $id_siswa,
            ]);
        }
        return redirect()->back()->with('success','Data berhasil diedit');
    }

    public function import_excel(){}

}
