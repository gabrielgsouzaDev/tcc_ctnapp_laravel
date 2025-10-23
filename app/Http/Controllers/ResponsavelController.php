<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use App\Models\Aluno;
use App\Services\FirebaseService;

class ResponsavelController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:responsaveis,email',
            'senha'=>'required|min:6',
            'raAluno'=>'required'
        ]);

        $aluno = Aluno::where('ra',$request->raAluno)->first();
        if(!$aluno) return response()->json(['erro'=>'RA não encontrado'],404);

        $uid = $this->firebase->criarUsuario($request->email,$request->senha,$request->nome);

        $responsavel = Responsavel::create([
            'nome'=>$request->nome,
            'email'=>$request->email,
            'senha_hash'=>bcrypt($request->senha),
            'uid_firebase'=>$uid
        ]);

        $responsavel->alunos()->attach($aluno->id_aluno);

        return response()->json(['sucesso'=>true,'uid'=>$uid]);
    }

    public function login(Request $request)
    {
        $request->validate(['idToken'=>'required']);
        $uid = $this->firebase->verificarToken($request->idToken);

        if(!$uid) return response()->json(['erro'=>'Token inválido'], 401);

        return response()->json(['uid'=>$uid,'sucesso'=>true]);
    }
}
