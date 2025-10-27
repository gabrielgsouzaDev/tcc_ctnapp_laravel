<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleParental extends Model
{
    protected $table = 'tb_controle_parental';
    protected $primaryKey = 'id_controle';
    public $timestamps = false;

    protected $fillable = [
        'id_aluno',
        'limite_diario',
        'limite_produto_id',
        'ativo',
        'dias_semana',
        'dt_criacao',
    ];

    // Relação com Aluno
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'id_aluno');
    }

    // Relação com Produto (se houver tabela de produtos)
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'limite_produto_id');
    }
}
