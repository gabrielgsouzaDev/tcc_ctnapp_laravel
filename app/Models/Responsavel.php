<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    protected $table = 'tb_responsavel';
    protected $primaryKey = 'id_responsavel';
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'uid_firebase'
    ];

    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'tb_aluno_responsavel', 
            'id_responsavel',
            'id_aluno'
        );
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_responsavel');
    }
}
