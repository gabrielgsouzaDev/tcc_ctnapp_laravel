<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Escola;

class EscolaController extends Controller
{
    public function listar()
    {
        return response()->json(Escola::all());
    }

    public function buscar($id)
    {
        $escola = Escola::find($id);
        if (!$escola) return response()->json(['error' => 'Escola não encontrada'], 404);
        return response()->json($escola);
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
        ]);

        $escola = Escola::create($request->all());
        return response()->json($escola, 201);
    }
}
