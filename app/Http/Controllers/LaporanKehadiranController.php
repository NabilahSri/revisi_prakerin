<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKehadiranExport;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanKehadiranController extends Controller
{
    public function show(Request $request){
        $data['kehadiran'] = null;
        if (auth()->user()->level == 'admin') {
            if ($request->isMethod('post')) {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                $id_kelas = $request->input('id_kelas');

                $data['kelas'] = Kelas::where('id',$id_kelas)->first();

                $data['siswa'] = Siswa::where('id_kelas',$data['kelas']->id)->get();
                $id_siswa = $data['siswa']->pluck('id');

                // Query untuk mencari data berdasarkan inputan
                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $id_siswa)->groupBy('id_siswa')->with('siswa')->get();
            }
        }else{
            if ($request->isMethod('post')) {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();

                $user = User::where('id',Auth::user()->id)->first();
                $pemonitor = Pemonitor::where('id_user',$user->id)->first();
                $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');

                $data['siswa'] = Siswa::whereIn('id',$monitor)->get();
                $id_siswa = $data['siswa']->pluck('id');

                // Query untuk mencari data berdasarkan inputan
                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $id_siswa)->groupBy('id_siswa')->with('siswa')->get();
            }
        }
        return view('pages.laporanKehadiran', ['kehadiran' => $data['kehadiran'],'kelas' => Kelas::all()]);
    }

    public function export_excel(Request $request){
        if (auth()->user()->level == 'admin') {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                $id_kelas = $request->input('id_kelas');

                $data['kelas'] = Kelas::where('id',$id_kelas)->first();

                $data['siswa'] = Siswa::where('id_kelas',$data['kelas']->id)->get();
                $id_siswa = $data['siswa']->pluck('id');

                // Query untuk mencari data berdasarkan inputan
                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $id_siswa)->groupBy('id_siswa')->with('siswa')->get();
                return Excel::download(new LaporanKehadiranExport($data['kehadiran']), 'laporan kehadiran per kelas.xlsx');
        }else{
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();

                $user = User::where('id',Auth::user()->id)->first();
                $pemonitor = Pemonitor::where('id_user',$user->id)->first();
                $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');

                $data['siswa'] = Siswa::whereIn('id',$monitor)->get();
                $id_siswa = $data['siswa']->pluck('id');

                // Query untuk mencari data berdasarkan inputan
                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $id_siswa)->groupBy('id_siswa')->with('siswa')->get();
                return Excel::download(new LaporanKehadiranExport($data['kehadiran']), 'laporan kehadiran per pemonitor.xlsx');
        }
    }

}
