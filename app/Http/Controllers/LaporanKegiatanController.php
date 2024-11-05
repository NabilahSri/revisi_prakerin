<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKegiatanExport;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKegiatanController extends Controller
{
    public function show(Request $request){
        $data['kegiatan'] = null;
        if (auth()->user()->level == 'admin') {
            $data['siswa'] = null;
            if ($request->isMethod('post')) {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                $id_kelas = $request->input('id_kelas');

                $data['kelas'] = Kelas::where('id',$id_kelas)->first();

                $data['siswa'] = Siswa::where('id_kelas',$data['kelas']->id)->get();

                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $data['siswa']->pluck('id'))->get();

                $data['kegiatan'] = Kegiatan::where('id_kelas', $id_kelas)->whereIn('id_kehadiran', $data['kehadiran']->pluck('id'))->select('id_siswa', DB::raw('SUM(durasi) as total_durasi_menit'))->groupBy('id_siswa')->with('siswa')->get();

                // Mengubah total durasi menit ke jam dan menit
                foreach ($data['kegiatan'] as $kegiatan) {
                    $jam = floor($kegiatan->total_durasi_menit / 60);
                    $menit = $kegiatan->total_durasi_menit % 60;
                    $kegiatan->total_durasi = "{$jam} jam {$menit} menit";
                }
            }
        }else{
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
            $siswa = Siswa::whereIn('id',$monitor)->get();
            if ($request->isMethod('post')) {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                $id_siswa = $request->input('id_siswa');

                $data['siswa'] = Siswa::where('id',$id_siswa)->get();

                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $data['siswa']->pluck('id'))->pluck('id');

                $data['kegiatan'] = Kegiatan::where('id_kehadiran', $data['kehadiran'])->with('kehadiran')->with('siswa')->get();

            }
        }
        return view('pages.laporanKegiatan', ['kegiatan' => $data['kegiatan'],'siswa' => $siswa, 'kelas' => Kelas::all()]);
    }

    public function export_excel(Request $request){
        if (auth()->user()->level == 'admin') {
                $tanggal_awal = $request->input('tanggal_awal');
                $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                $id_kelas = $request->input('id_kelas');

                $data['kelas'] = Kelas::where('id',$id_kelas)->first();

                $data['siswa'] = Siswa::where('id_kelas',$data['kelas']->id)->get();

                $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $data['siswa']->pluck('id'))->get();

                $data['kegiatan'] = Kegiatan::where('id_kelas', $id_kelas)->whereIn('id_kehadiran', $data['kehadiran']->pluck('id'))->select('id_siswa', DB::raw('SUM(durasi) as total_durasi_menit'))->groupBy('id_siswa')->with('siswa')->get();

                // Mengubah total durasi menit ke jam dan menit
                foreach ($data['kegiatan'] as $kegiatan) {
                    $jam = floor($kegiatan->total_durasi_menit / 60);
                    $menit = $kegiatan->total_durasi_menit % 60;
                    $kegiatan->total_durasi = "{$jam} jam {$menit} menit";
                }
                return Excel::download(new LaporanKegiatanExport($data['kegiatan']), 'laporan kegiatan per kelas.xlsx');
        }else{
                $user = User::where('id',Auth::user()->id)->first();
                $pemonitor = Pemonitor::where('id_user',$user->id)->first();
                $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
                $siswa = Siswa::whereIn('id', $monitor)->get();
                    $tanggal_awal = $request->input('tanggal_awal');
                    $tanggal_akhir = $request->input('tanggal_akhir') ?? now()->toDateString();
                    $id_siswa = $request->input('id_siswa');

                    $data['siswa'] = Siswa::where('id',$id_siswa)->get();

                    $data['kehadiran'] = Kehadiran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->whereIn('id_siswa', $data['siswa']->pluck('id'))->pluck('id');

                    $data['kegiatan'] = Kegiatan::where('id_kehadiran', $data['kehadiran'])->with('kehadiran')->with('siswa')->get();
                return Excel::download(new LaporanKegiatanExport($data['kegiatan']), 'laporan kegiatan per pemonitor.xlsx');
        }
    }
}
