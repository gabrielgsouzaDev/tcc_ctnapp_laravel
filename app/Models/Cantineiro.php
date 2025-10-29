<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cantineiro extends Model
{
    protected $table = 'tb_cantineiro';
    protected $primaryKey = 'id_cantineiro';
    public $timestamps = false;
    protected $fillable = ['id_usuario','id_cantina'];

    public function usuario(){ return $this->belongsTo(Usuario::class,'id_usuario','id_usuario'); }
    public function cantina(){ return $this->belongsTo(Cantina::class,'id_cantina','id_cantina'); }
}
