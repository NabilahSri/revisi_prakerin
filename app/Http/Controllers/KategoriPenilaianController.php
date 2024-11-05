<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaian as ModelsKategoriPenilaian;
use Illuminate\Http\Request;

class KategoriPenilaianController extends Controller
{
    public function show(){
        $data['kategori_penilaian'] = ModelsKategoriPenilaian::all();
        return view('pages.kategori_penilaian',$data);
    }

    public function add(Request $request){
        ModelsKategoriPenilaian::create([
            'kode' => $request->kode,
            'kategori' => $request->kategori,
        ]);
        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    public function delete(Request $request,$id){
        ModelsKategoriPenilaian::where('id',$id)->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }
}
