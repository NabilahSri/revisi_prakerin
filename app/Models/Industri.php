<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function token_masuk(){
        return $this->hasMany(TokenMasuk::class,'id_industri');
    }
    public function token_keluar(){
        return $this->hasMany(TokenKeluar::class,'id_industri');
    }
    public function monitoring(){
        return $this->hasMany(Monitoring::class,'id_industri');
    }
    public function penilaian(){
        return $this->hasMany(Penilaian::class,'id_industri');
    }
}
