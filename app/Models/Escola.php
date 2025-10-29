<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; // para usar Sanctum token
use Laravel\Sanctum\HasApiTokens;

class Escola extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'tb_escola';
    protected $primaryKey = 'id_escola';
    public $timestamps = false;
    protected $fillable = ['nome','cnpj','senha_hash','id_endereco','id_plano','status','qtd_alunos'];
    protected $hidden = ['senha_hash'];

    // Relações
    public function cantinas() { return $this->hasMany(Cantina::class, 'id_escola', 'id_escola'); }
    public function usuarios() { return $this->hasMany(Usuario::class, 'id_escola', 'id_escola'); }

    public function getAuthPassword()
    {
        return $this->senha_hash;
    }
}