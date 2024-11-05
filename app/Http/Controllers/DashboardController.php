<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show(Request $request){
        if (Auth::user()->level == 'admin') {
            $data['kelas'] = Kelas::all()->count();
            $data['industri'] = Industri::all()->count();
            $data['siswa'] = Siswa::all()->count();
            $data['pemonitor'] = Pemonitor::all()->count();
            $data['admin'] = User::where('level','admin')->count();
            $data['log_aktivitas'] = LogAktivitas::latest()->take(5)->get();
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $data['monitoring'] = Monitoring::where('id_pemonitor', $pemonitor->id)->distinct('id_industri')->count('id_industri');
        }elseif (Auth::user()->level == 'siswa'){
            $user = User::where('id',Auth::user()->id)->first();
            $siswa = Siswa::where('id_user',$user->id)->first();
            $kehadiran = Kehadiran::where('id_siswa',$siswa->id)->get();
            $data['hadir'] = Kehadiran::where('id_siswa',$siswa->id)->where('status','hadir')->count();
            $data['sakit'] = Kehadiran::where('id_siswa',$siswa->id)->where('status','sakit')->count();
            $data['izin'] = Kehadiran::where('id_siswa',$siswa->id)->where('status','izin')->count();
            $data['kegiatan'] = Kegiatan::where('id_kehadiran',$kehadiran->pluck('id'))->count();
        }else{
            $user = User::where('id',Auth::user()->id)->first();
            $industri = Industri::where('id_user',$user->id)->first();
            $data['siswa'] = Monitoring::where('id_industri',$industri->id)->distinct('id_siswa')->count('id_siswa');
        }
        return view('pages.dashboard',$data);
    }
}
