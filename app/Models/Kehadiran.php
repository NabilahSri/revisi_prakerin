<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function siswa(){
        return $this->belongsTo(Siswa::class,'id_siswa');
    }
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function kegiatan(){
        return $this->hasMany(Kegiatan::class,'id_kehadiran');
    }
}
