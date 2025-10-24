<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    protected $table = 'tb_responsavel'; // nome real da tabela
    protected $primaryKey = 'id_responsavel';
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'uid_firebase'
    ];

    // Relação com Alunos (N:N)
    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'tb_aluno_responsavel', // nome correto da tabela pivô
            'id_responsavel',
            'id_aluno'
        );
    }

    // Relação com Pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_responsavel');
    }
}
