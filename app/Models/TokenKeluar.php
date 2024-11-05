<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenKeluar extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function industri(){
        return $this->belongsTo(Industri::class,'id_industri');
    }
}
