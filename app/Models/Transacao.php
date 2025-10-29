<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $table = 'tb_transacao';
    protected $primaryKey = 'id_transacao';
    public $timestamps = false;
    const CREATED_AT = 'dt_transacao';
    protected $fillable = ['id_carteira','id_usuario_autor','id_admin_aprovador','uuid','tipo','valor','descricao'];

    public function carteira(){ return $this->belongsTo(Carteira::class,'id_carteira','id_carteira'); }
    public function autor(){ return $this->belongsTo(Usuario::class,'id_usuario_autor','id_usuario'); }
    public function aprovador(){ return $this->belongsTo(Admin::class,'id_admin_aprovador','id_admin'); }
}
