<?php

namespace App\Http\Controllers;

use App\Models\ControleParental;
use Illuminate\Http\Request;

class ControleParentalController extends Controller
{
    public function index()
    {
        return response()->json(ControleParental::with('aluno', 'produto')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_aluno' => 'required|exists:tb_aluno,id_aluno',
            'limite_diario' => 'numeric|min:0',
            'limite_produto_id' => 'nullable|exists:tb_produto,id_produto',
            'ativo' => 'boolean',
            'dias_semana' => 'nullable|string|max:50',
        ]);

        $controle = ControleParental::create($validated);

        return response()->json(['message' => 'Controle parental criado.', 'data' => $controle], 201);
    }

    public function show($id)
    {
        $controle = ControleParental::with('aluno', 'produto')->findOrFail($id);
        return response()->json($controle);
    }

    public function update(Request $request, $id)
    {
        $controle = ControleParental::findOrFail($id);

        $validated = $request->validate([
            'limite_diario' => 'numeric|min:0',
            'limite_produto_id' => 'nullable|exists:tb_produto,id_produto',
            'ativo' => 'boolean',
            'dias_semana' => 'nullable|string|max:50',
        ]);

        $controle->update($validated);

        return response()->json(['message' => 'Controle parental atualizado.', 'data' => $controle]);
    }

    public function destroy($id)
    {
        ControleParental::findOrFail($id)->delete();
        return response()->json(['message' => 'Controle parental removido.']);
    }
}
