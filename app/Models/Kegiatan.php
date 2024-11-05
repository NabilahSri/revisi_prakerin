<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function kehadiran(){
        return $this->belongsTo(Kehadiran::class,'id_kehadiran');
    }
    public function siswa(){
        return $this->belongsTo(Siswa::class,'id_siswa');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class,'id_kelas');
    }
}
