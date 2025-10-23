<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $fillable = [
        'nome','cnpj','id_endereco','id_plano','status','qtd_alunos',
        'email_contato','senha_hash','nm_gerente','telefone_contato'
    ];

    public function alunos() {
        return $this->hasMany(Aluno::class, 'id_escola');
    }

    public function cantinas() {
        return $this->hasMany(Cantina::class, 'id_escola');
    }

    public function plano() {
        return $this->belongsTo(Plano::class, 'id_plano');
    }

    public function endereco() {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }
}
