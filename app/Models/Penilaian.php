<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function siswa(){
        return $this->belongsTo(Siswa::class,'id_siswa');
    }
    public function industri(){
        return $this->belongsTo(Industri::class,'id_industri');
    }
    public function kategori_penilaian(){
        return $this->belongsTo(KategoriPenilaian::class,'id_kategori_penilaian');
    }
}
