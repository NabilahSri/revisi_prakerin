<?php

namespace App\Http\Controllers;

use App\Imports\PemonitorImport;
use App\Models\Pemonitor;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PemonitorController extends Controller
{
    public function show(){
        $data['user'] = User::where('level','pemonitor')->get();
        $data['pemonitor'] = Pemonitor::with('user')->get();
        return view('pages.pemonitor',$data);
    }

    public function import_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new PemonitorImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil di import');
    }

    public function add(Request $request){
        User::create([
            'username' => $request->username,
            'password' => bcrypt('12341234'),
            'level' => 'pemonitor'
        ]);
        $user = User::where('username',$request->username)->first();
        Pemonitor::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'id_user' => $user->id
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Request $request, $id){
        $pemonitor = Pemonitor::find($id);
        $user = User::find($pemonitor->id_user);

        $user->username = $request->username;
        $user->level = 'pemonitor';
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $pemonitor->nip = $request->nip;
        $pemonitor->name = $request->name;
        $pemonitor->email = $request->email;
        $pemonitor->telp = $request->telp;
        $pemonitor->alamat = $request->alamat;
        $pemonitor->save();
        return redirect()->back()->with('success', 'Data berhasil diedit');
    }

    public function delete(Request $request, $id){
        $pemonitor = Pemonitor::find($id);
        $deletPemonitor = Pemonitor::where('id', $id)->delete();

        $user = User::find($pemonitor->id_user);
        $user->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
