<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'tb_funcionario';
    protected $primaryKey = 'id_funcionario';
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'cargo',
        'id_escola',
        'uid_firebase',
    ];

    // Relação com Escola
    public function escola()
    {
        return $this->belongsTo(Escola::class, 'id_escola');
    }

    // Relação com Carteira
    public function carteira()
    {
        return $this->hasOne(Carteira::class, 'id_usuario')
            ->where('tipo_usuario', 'Funcionario');
    }
}
