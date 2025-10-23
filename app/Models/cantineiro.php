<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cantineiro extends Model
{
    protected $fillable = ['nome','email','senha_hash','id_cantina'];

    public function cantina() {
        return $this->belongsTo(Cantina::class,'id_cantina');
    }
}
