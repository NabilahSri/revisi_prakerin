<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    public function show(Request $request){
        $data['kelas'] = Kelas::all();
        return view('pages.kelas',$data);
    }

    public function add(Request $request){
        Kelas::create([
            'kelas' => $request->kelas,
        ]);
        return redirect()->back()->with('success','Data berhasil ditambahkan');
    }

    public function import_excel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new KelasImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil di import');
    }

    public function delete(Request $request,$id){
        Kelas::where('id',$id)->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }
}
