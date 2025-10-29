<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    protected $table = 'tb_carteira';
    protected $primaryKey = 'id_carteira';
    public $timestamps = false;
    protected $fillable = ['id_usuario','limite_recarregar','limite_maximo_saldo'];
    protected $casts = ['saldo'=>'float','saldo_bloqueado'=>'float'];

    public function usuario(){ return $this->belongsTo(Usuario::class,'id_usuario','id_usuario'); }
    public function transacoes(){ return $this->hasMany(Transacao::class,'id_carteira','id_carteira'); }
    public function getSaldoDisponivelAttribute(){ return $this->saldo - $this->saldo_bloqueado; }
}
