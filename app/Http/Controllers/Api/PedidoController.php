<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Usuario;

class PedidoController extends Controller
{
    // Criar pedido
    public function fazerPedido(Request $request)
    {
        $request->validate([
            'id_aluno' => 'required|integer|exists:tb_usuario,id',
            'itens' => 'required|array',
        ]);

        $aluno = Usuario::where('id', $request->id_aluno)->where('role', 'aluno')->first();
        if (!$aluno) {
            return response()->json(['error' => 'Aluno inválido'], 404);
        }

        $total = 0;
        foreach ($request->itens as $item) {
            $produto = Produto::find($item['id_produto']);
            if (!$produto) {
                return response()->json(['error' => "Produto {$item['id_produto']} não encontrado"], 404);
            }
            $total += $produto->preco * $item['quantidade'];
        }

        if ($aluno->saldo < $total) {
            return response()->json(['error' => 'Saldo insuficiente'], 400);
        }

        $pedido = Pedido::create([
            'id_aluno' => $aluno->id,
            'total' => $total,
            'itens' => json_encode($request->itens)
        ]);

        $aluno->saldo -= $total;
        $aluno->save();

        return response()->json(['pedido' => $pedido, 'saldo_restante' => $aluno->saldo]);
    }

    // Histórico de pedidos
    public function historicoPedidos($id_aluno)
    {
        $pedidos = Pedido::where('id_aluno', $id_aluno)->get();
        return response()->json($pedidos);
    }
}
