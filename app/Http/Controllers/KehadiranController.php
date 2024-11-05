<?php

namespace App\Http\Controllers;

use App\Exports\KehadiranExport;
use App\Models\Industri;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class KehadiranController extends Controller
{
    public function show(){
        $data['kelas'] = Kelas::all();
        if (Auth::user()->level == 'admin') {
            $data['siswa'] = Siswa::with('kelas')->get();
            $data['kehadiran'] = Kehadiran::with('siswa')->orderBy('created_at','desc')->get();
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id', Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user', $user->id)->first();
            $id_pemonitor = $pemonitor->id;
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('kelas')->get();
            $monitoring = Monitoring::where('id_pemonitor',$pemonitor->id)->get();
            $data['kehadiran'] = Kehadiran::with(['siswa' => function($query) use ($id_pemonitor) {
                $query->whereHas('monitoring', function ($query) use ($id_pemonitor){
                    $query->where('id_pemonitor',$id_pemonitor);
                });
            }])->whereHas('siswa.monitoring', function($query) use ($id_pemonitor){
                    $query->where('id_pemonitor',$id_pemonitor);
                })->get();
        }elseif(Auth::user()->level == 'siswa'){
            $user = User::where('id', Auth::user()->id)->first();
            $siswa = Siswa::where('id_user',$user->id)->first();
            $data['kehadiran'] = Kehadiran::where('id_siswa',$siswa->id)->get();
        }else{
            $user = User::where('id', Auth::user()->id)->first();
            $industri = Industri::where('id_user', $user->id)->first();
            $id_industri = $industri->id;
            $monitor = Monitoring::where('id_industri',$industri->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('kelas')->get();
            $monitoring = Monitoring::where('id_industri',$industri->id)->get();
            $data['kehadiran'] = Kehadiran::with(['siswa' => function($query) use ($id_industri) {
                $query->whereHas('monitoring', function ($query) use ($id_industri){
                    $query->where('id_industri',$id_industri);
                });
            }])->whereHas('siswa.monitoring', function($query) use ($id_industri){
                    $query->where('id_industri',$id_industri);
                })->get();
        }
        return view('pages.kehadiran',$data);
    }

    public function add(Request $request){
        Kehadiran::create([
            'tanggal' => $request->tanggal,
            'jam_masuk' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
            'status' => $request->status,
            'catatan' => $request->catatan,
            'bukti' => $request->bukti,
            'id_siswa' => $request->id_siswa,
            'id_user' => Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Kehadiran berhasil di tambahkan');
    }

    public function export_excel(){
        $data['kelas'] = Kelas::all();
        if (Auth::user()->level == 'admin') {
            $data['siswa'] = Siswa::with('kelas')->get();
            $data['kehadiran'] = Kehadiran::with('siswa')->orderBy('created_at','desc')->get();
            return Excel::download(new KehadiranExport($data['kehadiran']), 'kehadiran per hari.xlsx');
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id', Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user', $user->id)->first();
            $id_pemonitor = $pemonitor->id;
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('kelas')->get();
            $monitoring = Monitoring::where('id_pemonitor',$pemonitor->id)->get();
            $data['kehadiran'] = Kehadiran::with(['siswa' => function($query) use ($id_pemonitor) {
                $query->whereHas('monitoring', function ($query) use ($id_pemonitor){
                    $query->where('id_pemonitor',$id_pemonitor);
                });
            }])->whereHas('siswa.monitoring', function($query) use ($id_pemonitor){
                    $query->where('id_pemonitor',$id_pemonitor);
                })->get();
            return Excel::download(new KehadiranExport($data['kehadiran']), 'kehadiran per pemonitor.xlsx');
        }
    }
}
