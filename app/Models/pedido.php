<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['id_aluno','id_responsavel','id_cantina','status'];

    public function aluno() {
        return $this->belongsTo(Aluno::class,'id_aluno');
    }

    public function responsavel() {
        return $this->belongsTo(Responsavel::class,'id_responsavel');
    }

    public function cantina() {
        return $this->belongsTo(Cantina::class,'id_cantina');
    }

    public function itens() {
        return $this->hasMany(ItemPedido::class,'id_pedido');
    }
}

