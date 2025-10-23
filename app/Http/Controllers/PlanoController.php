<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;

class PlanoController extends Controller
{
    public function listarPlanos()
    {
        $planos = Plano::all();
        return response()->json($planos);
    }

    public function cadastrarPlano(Request $request)
    {
        $request->validate([
            'nome'=>'required|string|max:50',
            'qtd_max_alunos'=>'required|integer|min:0',
            'qtd_max_cantinas'=>'required|integer|min:0',
            'preco_mensal'=>'required|numeric|min:0'
        ]);

        $plano = Plano::create([
            'nome' => $request->nome,
            'qtd_max_alunos' => $request->qtd_max_alunos,
            'qtd_max_cantinas' => $request->qtd_max_cantinas,
            'preco_mensal' => $request->preco_mensal
        ]);

        return response()->json(['sucesso'=>true,'plano'=>$plano]);
    }

    public function buscarPlano($id_plano)
    {
        $plano = Plano::find($id_plano);
        if(!$plano) return response()->json(['erro'=>'Plano não encontrado'],404);
        return response()->json($plano);
    }
}
