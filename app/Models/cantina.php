<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cantina extends Model
{
    protected $fillable = ['nome','id_escola'];

    public function escola() {
        return $this->belongsTo(Escola::class,'id_escola');
    }

    public function cantineiros() {
        return $this->hasMany(Cantineiro::class,'id_cantina');
    }

    public function produtos() {
        return $this->hasMany(Produto::class,'id_cantina');
    }
}
