<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pemonitor extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function monitoring(){
        return $this->hasMany(Monitoring::class,'id_pemonitor');
    }
}
