<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'tb_admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;
    protected $fillable = ['nome','email','senha_hash'];
    protected $hidden = ['senha_hash'];

    public function getAuthPassword()
    {
        return $this->senha_hash;
    }
}
