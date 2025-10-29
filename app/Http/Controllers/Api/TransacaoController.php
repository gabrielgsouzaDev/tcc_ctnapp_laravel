<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Models\Usuario;

class TransacaoController extends Controller
{
    public function listarTransacoes(Request $request, $id_usuario)
    {
        $usuario = Usuario::find($id_usuario);
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $transacoes = Transacao::where('id_usuario', $id_usuario)->get();
        return response()->json($transacoes);
    }

    public function criarTransacao(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|exists:tb_usuario,id',
            'tipo' => 'required|string|in:entrada,saida',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);

        $transacao = Transacao::create($request->all());

        // Atualizar saldo do usuário
        $usuario = Usuario::find($request->id_usuario);
        if ($request->tipo === 'entrada') {
            $usuario->saldo += $request->valor;
        } else {
            $usuario->saldo -= $request->valor;
        }
        $usuario->save();

        return response()->json($transacao, 201);
    }
}
