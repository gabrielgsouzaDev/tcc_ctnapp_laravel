<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $table = 'tb_transacao';
    protected $primaryKey = 'id_transacao';
    public $timestamps = false;

    protected $fillable = [
        'id_carteira',
        'tipo',
        'valor',
        'descricao',
        'dt_transacao',
    ];

    // Relação com Carteira
    public function carteira()
    {
        return $this->belongsTo(Carteira::class, 'id_carteira');
    }
}
