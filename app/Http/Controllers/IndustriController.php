<?php

namespace App\Http\Controllers;

use App\Imports\IndustriImport;
use App\Models\Industri;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IndustriController extends Controller
{
    public function show(){
        $data['user'] = User::all();
        if (Auth::user()->level == 'admin') {
            $data['industri'] = Industri::with('user')->get();
        }elseif (Auth::user()->level == 'pemonitor') {
            $user = User::where('id',Auth::user()->id)->first();
            $pemonitor = Pemonitor::where('id_user',$user->id)->first();
            $monitor = Monitoring::where('id_pemonitor',$pemonitor->id)->pluck('id_industri');
            $data['industri'] = Industri::whereIn('id',$monitor)->with('user')->get();
        }
        return view('pages.industri',$data);
    }

    public function add(Request $request){
        User::create([
            'username' => $request->username,
            'password' => bcrypt('12341234'),
            'level' => 'industri'
        ]);
        $user = User::where('username',$request->username)->first();
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->storeAs('logo_industri', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = null;
        }
        Industri::create([
            'name' => $request->name,
            'ceo' => $request->ceo,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'id_user' => $user->id,
            'email' => $request->email,
            'logo' => $photoPath
        ]);

        return redirect()->back()->with('success','Data berhasil ditambahkan');
    }

    public function edit(Request $request, $id){
        $industri = Industri::find($id);
        $user = User::find($industri->id_user);

        $user->username = $request->username;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->level = 'industri';
        $user->save();

        if ($request->hasFile('foto')) {
            if ($industri->foto) {
                Storage::delete('logo_industri/'.$industri->logo);
            }
            $photoPath = $request->file('foto')->storeAs('logo_industri', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
        } else {
            $photoPath = $industri->logo;
        }
        $industri->name = $request->name;
        $industri->ceo = $request->ceo;
        $industri->alamat = $request->alamat;
        $industri->telp = $request->telp;
        $industri->email = $request->email;
        $industri->logo = $photoPath;
        $industri->save();

        return redirect()->back()->with('success','Data berhasil diedit');

    }

    public function delete($id){
        $industri = Industri::find($id);
        $deleteIndustri = Industri::where('id',$id)->delete();
        if ($deleteIndustri) {
            Storage::delete('logo_industri/'.$industri->foto);
        }

        $user = User::find($industri->id_user);
        $user->delete();

        return redirect()->back()->with('success','Data berhasil dihapus');

    }

    public function import_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new IndustriImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil di import');
    }
}
