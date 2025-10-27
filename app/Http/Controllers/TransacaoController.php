<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use Illuminate\Http\Request;

class TransacaoController extends Controller
{
    public function index()
    {
        return response()->json(Transacao::with('carteira')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_carteira' => 'required|exists:tb_carteira,id_carteira',
            'tipo' => 'required|in:PIX,Recarregar,PagamentoEscola,Debito',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'nullable|string|max:255',
        ]);

        $transacao = Transacao::create($validated);

        // Atualiza saldo da carteira
        $carteira = $transacao->carteira;
        if ($transacao->tipo === 'Recarregar' || $transacao->tipo === 'PIX') {
            $carteira->saldo += $transacao->valor;
        } else {
            $carteira->saldo -= $transacao->valor;
        }
        $carteira->save();

        return response()->json(['message' => 'Transação registrada.', 'data' => $transacao], 201);
    }

    public function show($id)
    {
        $transacao = Transacao::with('carteira')->findOrFail($id);
        return response()->json($transacao);
    }

    public function destroy($id)
    {
        Transacao::findOrFail($id)->delete();
        return response()->json(['message' => 'Transação removida.']);
    }
}
