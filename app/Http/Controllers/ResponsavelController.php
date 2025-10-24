<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResponsavelController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|unique:tb_responsavel,email',
            'senha' => 'required|string|min:6',
            'ra_aluno' => 'required|string',
            'uid_firebase' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $aluno = Aluno::where('ra', $request->ra_aluno)->first();
            if (!$aluno) {
                throw new \Exception('RA do aluno inválido ou não encontrado.');
            }

            $responsavel = Responsavel::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'senha_hash' => Hash::make($request->senha),
                'uid_firebase' => $request->uid_firebase,
            ]);

            $responsavel->alunos()->attach($aluno->id_aluno);

            DB::commit();
            return response()->json(['message' => 'Responsável cadastrado com sucesso.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
