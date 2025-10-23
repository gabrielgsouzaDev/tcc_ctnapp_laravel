<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['ra','nome','email','senha_hash','id_escola','uid_firebase'];

    public function escola() {
        return $this->belongsTo(Escola::class,'id_escola');
    }

    public function responsaveis() {
        return $this->belongsToMany(Responsavel::class,'aluno_responsavel','id_aluno','id_responsavel');
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class,'id_aluno');
    }
}
