<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'tb_usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $fillable = ['nome','email','senha_hash','uid_firebase','id_escola','cargo','saldo_ativo'];
    protected $hidden = ['senha_hash'];

    public function escola() { return $this->belongsTo(Escola::class,'id_escola','id_escola'); }
    public function carteira() { return $this->hasOne(Carteira::class,'id_usuario','id_usuario'); }
    public function roles() { return $this->belongsToMany(Role::class,'tb_usuario_role','id_usuario','id_role'); }
    public function isCantineiro() {
        return \DB::table('tb_cantineiro')->where('id_usuario',$this->id_usuario)->exists();
    }

    public function getAuthPassword()
    {
        return $this->senha_hash;
    }
}
