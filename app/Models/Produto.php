<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome','preco','id_cantina'];

    public function cantina() {
        return $this->belongsTo(Cantina::class,'id_cantina');
    }

    public function itensPedido() {
        return $this->hasMany(ItemPedido::class,'id_produto');
    }
}
