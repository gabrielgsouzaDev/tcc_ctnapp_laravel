<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    // Listar todos os funcionários
    public function index()
    {
        return response()->json(Funcionario::with('escola', 'carteira')->get());
    }

    // Criar novo funcionário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|unique:tb_funcionario,email',
            'senha_hash' => 'required|string|min:6',
            'cargo' => 'in:Professor,Faxineiro,Outro',
            'id_escola' => 'required|exists:tb_escola,id_escola',
            'uid_firebase' => 'nullable|string|max:128|unique:tb_funcionario,uid_firebase',
        ]);

        $funcionario = Funcionario::create($validated);

        return response()->json([
            'message' => 'Funcionário criado com sucesso.',
            'data' => $funcionario
        ], 201);
    }

    // Exibir um funcionário específico
    public function show($id)
    {
        $funcionario = Funcionario::with('escola', 'carteira')->findOrFail($id);
        return response()->json($funcionario);
    }

    // Atualizar dados
    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|email|unique:tb_funcionario,email,' . $id . ',id_funcionario',
            'senha_hash' => 'sometimes|string|min:6',
            'cargo' => 'in:Professor,Faxineiro,Outro',
            'id_escola' => 'sometimes|exists:tb_escola,id_escola',
            'uid_firebase' => 'nullable|string|max:128|unique:tb_funcionario,uid_firebase,' . $id . ',id_funcionario',
        ]);

        $funcionario->update($validated);

        return response()->json(['message' => 'Funcionário atualizado.', 'data' => $funcionario]);
    }

    // Deletar funcionário
    public function destroy($id)
    {
        Funcionario::findOrFail($id)->delete();
        return response()->json(['message' => 'Funcionário removido com sucesso.']);
    }
}
