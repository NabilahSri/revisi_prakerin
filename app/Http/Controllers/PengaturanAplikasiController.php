<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanAplikasiController extends Controller
{
    public function show(){
        return view('pages.pengaturan_aplikasi');
    }
}
