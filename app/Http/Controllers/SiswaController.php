<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function show(){
        $data['user'] = User::where('level','siswa')->get();
        $data['kelas'] = Kelas::all();
        if (Auth::user()->level == 'admin') {
            $data['siswa'] = Siswa::with('user')->with('kelas')->get();
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('user')->with('kelas')->get();
        }else{
            $user = User::where('id',Auth::user()->id)->first();
            $industri = Industri::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_industri',$industri->id)->pluck('id_siswa');
            $data['siswa'] = Siswa::whereIn('id',$monitor)->with('user')->with('kelas')->get();
        }
        return view('pages.siswa',$data);
    }

    public function add(Request $request){
        User::create([
            'username' => $request->username,
            'password' => bcrypt('12341234'),
            'level' => 'siswa'
        ]);
        $user = User::where('username',$request->username)->first();
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->storeAs('foto_siswa', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = null;
        }
        Siswa::create([
            'nisn' => $request->nisn,
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'long' => $request->long,
            'kunci_lokasi' => 0,
            'foto' => $photoPath,
            'id_user' => $user->id,
            'id_kelas' => $request->id_kelas
        ]);
        return redirect()->back()->with('success','Data berhasil ditambahkan');
    }

    public function edit(Request $request,$id){
        $siswa = Siswa::find($id);
        $user = User::find($siswa->id_user);
        $user->username = $request->username;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->level = 'siswa';
        $user->save();

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::delete('foto_siswa/'.$siswa->foto);
            }
            $photoPath = $request->file('foto')->storeAs('foto_siswa', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = $siswa->foto;
        }
        $siswa->nisn = $request->nisn;
        $siswa->name = $request->name;
        $siswa->email = $request->email;
        $siswa->telp = $request->telp;
        $siswa->alamat = $request->alamat;
        $siswa->lat = $request->lat;
        $siswa->long = $request->long;
        $siswa->foto = $photoPath;
        $siswa->id_kelas = $request->id_kelas;
        // dd($siswa);
        $siswa->save();


        return redirect()->back()->with('success','Data berhasil diedit');
    }

    public function delete($id){
        $siswa = Siswa::find($id);
        $deleteSiswa = Siswa::where('id',$id)->delete();
        if ($deleteSiswa) {
            Storage::delete('foto_siswa/'.$siswa->foto);
        }

        $user = User::find($siswa->id_user);
        $user->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function import_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil di import');
    }

    public function update_kunci_lokasi(Request $request, $id){
        $updateKunciLokasi = Siswa::where('id',$id)->update([
            'kunci_lokasi' => $request->kunci_lokasi
        ]);
        if ($updateKunciLokasi) {
            return redirect()->back()->with('success', 'Kunci lokasi berhasil di update');
        }else{
            return redirect()->back()->with('error', 'Kunci lokasi gagal di update');
        }
    }

}
