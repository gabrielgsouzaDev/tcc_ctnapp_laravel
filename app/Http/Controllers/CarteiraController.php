<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use Illuminate\Http\Request;

class CarteiraController extends Controller
{
    public function index()
    {
        return response()->json(Carteira::with('transacoes')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_usuario' => 'required|in:Aluno,Responsavel,Funcionario',
            'id_usuario' => 'required|integer',
            'saldo' => 'numeric|min:0',
            'limite_recarregar' => 'nullable|numeric|min:0',
        ]);

        $carteira = Carteira::create($validated);

        return response()->json(['message' => 'Carteira criada.', 'data' => $carteira], 201);
    }

    public function show($id)
    {
        $carteira = Carteira::with('transacoes')->findOrFail($id);
        return response()->json($carteira);
    }

    public function update(Request $request, $id)
    {
        $carteira = Carteira::findOrFail($id);

        $validated = $request->validate([
            'saldo' => 'numeric|min:0',
            'limite_recarregar' => 'nullable|numeric|min:0',
        ]);

        $carteira->update($validated);

        return response()->json(['message' => 'Carteira atualizada.', 'data' => $carteira]);
    }

    public function destroy($id)
    {
        Carteira::findOrFail($id)->delete();
        return response()->json(['message' => 'Carteira removida.']);
    }
}
