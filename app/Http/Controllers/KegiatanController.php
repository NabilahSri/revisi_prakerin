<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function show(){
        $user = User::where('id',auth()->user()->id)->first();
        $siswa = Siswa::where('id_user',$user->id)->first();
        $data['kegiatan'] = Kegiatan::where('id_siswa',$siswa->id)->with('kehadiran')->get();
        $data['tanggal_kehadiran'] = Kegiatan::where('id_siswa',$siswa->id)->with('kehadiran')->groupBy('id_kehadiran')->get();
        return view('pages.kegiatan',$data);
    }

    public function add(Request $request){
        $user = User::where('id',auth()->user()->id)->first();
        $siswa = Siswa::where('id_user',$user->id)->with('kelas')->first();
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->storeAs('foto_kegiatan', $request->id_kehadiran . '_' . $request->id_siswa . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = null;
        }
        Kegiatan::create([
            'deskripsi' => $request->deskripsi,
            'foto' => $photoPath,
            'durasi' => $request->durasi,
            'id_kehadiran' => $request->id_kehadiran,
            'id_siswa' => $siswa->id,
            'id_kelas' => $siswa->kelas->id,
        ]);
        return redirect()->back()->with('success','kegiatan berhasil ditambahkan');
    }

    public function edit(Request $request,$id){
        $user = User::where('id',auth()->user()->id)->first();
        $siswa = Siswa::where('id_user',$user->id)->with('kelas')->first();
        $kegiatan = Kegiatan::where('id',$id)->first();
        if ($request->hasFile('foto')) {
            if ($kegiatan->foto) {
                Storage::delete('foto_kegiatan/'.$kegiatan->foto);
            }
            $photoPath = $request->file('foto')->storeAs('foto_kegiatan', $request->id_kehadiran . '_' . $request->id_siswa . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = $kegiatan->foto;
        }
        Kegiatan::where('id',$id)->update([
            'deskripsi' => $request->deskripsi,
            'foto' => $photoPath,
            'durasi' => $request->durasi,
            'id_kehadiran' => $request->id_kehadiran,
            'id_siswa' => $siswa->id,
            'id_kelas' => $siswa->kelas->id,
        ]);

        return redirect()->back()->with('success','kegiatan berhasil diedit');
    }

    public function delete(Request $request,$id){
        $kegiatan = Kegiatan::where('id',$id)->first();
        $deletekegiatan = Kegiatan::where('id',$id)->delete();
        if ($deletekegiatan) {
            Storage::delete('foto_kegiatan/'.$kegiatan->foto);
        }
        return redirect()->back()->with('success','kegiatan berhasil dihapus');
    }
}
