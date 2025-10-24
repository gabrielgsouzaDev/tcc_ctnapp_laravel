<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'tb_aluno'; // nome real da tabela
    protected $primaryKey = 'id_aluno';
    public $timestamps = true;

    protected $fillable = [
        'ra',
        'nome',
        'email',
        'senha_hash',
        'id_escola',
        'uid_firebase'
    ];

    // Relação com Escola
    public function escola()
    {
        return $this->belongsTo(Escola::class, 'id_escola');
    }

    // Relação com Responsáveis (N:N)
    public function responsaveis()
    {
        return $this->belongsToMany(
            Responsavel::class,
            'tb_aluno_responsavel', // nome correto da tabela pivô
            'id_aluno',
            'id_responsavel'
        );
    }

    // Relação com Pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_aluno');
    }
}
