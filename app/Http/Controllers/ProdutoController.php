<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function listarProdutos($id_cantina)
    {
        $produtos = Produto::where('id_cantina',$id_cantina)->get();
        return response()->json($produtos);
    }
}
