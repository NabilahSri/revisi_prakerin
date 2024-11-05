<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Siswa extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class,'id_kelas');
    }
    public function monitoring(){
        return $this->hasOne(Monitoring::class,'id_siswa');
    }
    public function kehadiran(){
        return $this->hasMany(Kehadiran::class,'id_siswa');
    }
    public function kegiatan(){
        return $this->hasMany(Kegiatan::class,'id_siswa');
    }
    public function penilaian(){
        return $this->hasMany(Penilaian::class,'id_siswa');
    }
}
