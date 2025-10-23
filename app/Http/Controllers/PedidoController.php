<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function fazerPedido(Request $request)
    {
        $request->validate([
            'id_aluno'=>'required|integer',
            'id_cantina'=>'required|integer',
            'itens'=>'required|array|min:1'
        ]);

        $pedido = DB::transaction(function() use ($request) {
            $pedido = Pedido::create([
                'id_aluno'=>$request->id_aluno,
                'id_cantina'=>$request->id_cantina,
                'status'=>'pendente'
            ]);

            foreach($request->itens as $item){
                $pedido->itens()->create($item);
            }

            return $pedido;
        });

        return response()->json(['sucesso'=>true,'id_pedido'=>$pedido->id_pedido]);
    }

    public function historicoPedidos($id_aluno)
    {
        $pedidos = Pedido::with('itens.produto')
            ->where('id_aluno',$id_aluno)
            ->orderBy('dt_pedido','desc')
            ->get();

        return response()->json($pedidos);
    }

    public function updateSaldo(Request $request)
    {
        $request->validate([
            'id_aluno'=>'required|integer',
            'valor'=>'required|numeric'
        ]);

        $aluno = Aluno::find($request->id_aluno);
        if(!$aluno) return response()->json(['erro'=>'Aluno não encontrado'],404);

        $aluno->saldo += $request->valor;
        $aluno->save();

        return response()->json(['sucesso'=>true]);
    }
}
