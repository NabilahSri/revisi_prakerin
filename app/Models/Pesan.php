<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function userPengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim');
    }

    public function userPenerima()
    {
        return $this->belongsTo(User::class, 'id_penerima');
    }
}
