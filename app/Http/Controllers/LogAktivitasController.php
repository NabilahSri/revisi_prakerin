<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function show(){
        $data['log_aktivitas'] = LogAktivitas::orderBy('created_at','desc')->get();
        return view('pages.log_aktivitas',$data);
    }
}
