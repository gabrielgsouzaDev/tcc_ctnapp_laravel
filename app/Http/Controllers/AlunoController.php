<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Responsavel;
use App\Services\FirebaseService;

class AlunoController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function login(Request $request)
    {
        $request->validate(['idToken'=>'required']);
        $uid = $this->firebase->verificarToken($request->idToken);

        if(!$uid) return response()->json(['erro'=>'Token inválido'], 401);

        $responsavel = Responsavel::where('uid_firebase',$uid)->first();
        if(!$responsavel) return response()->json(['erro'=>'Responsável não encontrado'], 404);

        $alunos = $responsavel->alunos;
        return response()->json(['alunos'=>$alunos]);
    }

    public function getSaldo($id_aluno)
    {
        $aluno = Aluno::find($id_aluno);
        if(!$aluno) return response()->json(['erro'=>'Aluno não encontrado'],404);

        return response()->json(['saldo'=>$aluno->saldo ?? 0]);
    }
}
