<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = ['nome','qtd_max_alunos','qtd_max_cantinas','preco_mensal'];
}
