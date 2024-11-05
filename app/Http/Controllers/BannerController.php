<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function show(){
        $data['banner'] = Banner::all();
        return view('pages.banner',$data);
    }

    public function add(Request $request){
        if ($request->hasFile('gambar')) {
            $photoPath = $request->file('gambar')->storeAs('gambar_banner', $request->name . '.' . $request->file('gambar')->getClientOriginalExtension());
        } else {
            $photoPath = null;
        }
        Banner::create([
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'gambar' => $photoPath,
        ]);
        return redirect()->back()->with('success','Data berhaisl ditambahkan');
    }

    public function delete(Request $request,$id){
        $banner = Banner::find($id);
        $deleteBanner = Banner::where('id',$id)->delete();
        if ($deleteBanner) {
            Storage::delete($banner->gambar);
        }
        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function edit(Request $request,$id){
        $banner = Banner::find($id);
        $bannerData = [
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('gambar')) {
            if ($banner->gambar) {
                Storage::delete($banner->gambar);
            }
            $photoPath = $request->file('gambar')->storeAs('gambar_banner', $request->name . '.' . $request->file('gambar')->getClientOriginalExtension());
            $bannerData['gambar'] = $photoPath;
        }
        Banner::where('id', $id)->update($bannerData);
        return redirect()->back()->with('success','Data berhasil diedit');
    }
}
