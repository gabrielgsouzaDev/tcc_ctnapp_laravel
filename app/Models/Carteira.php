<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    protected $table = 'tb_carteira';
    protected $primaryKey = 'id_carteira';
    public $timestamps = false;

    protected $fillable = [
        'tipo_usuario',
        'id_usuario',
        'saldo',
        'limite_recarregar',
        'dt_ultima_atualizacao',
    ];

    // Relação com Transações
    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'id_carteira');
    }
}
