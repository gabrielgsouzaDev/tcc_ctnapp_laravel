<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\FirebaseService;

class UsuarioController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    // Login genérico para qualquer usuário do app
    public function login(Request $request)
    {
        $idToken = $request->header('Authorization') ? preg_replace('/Bearer\s/', '', $request->header('Authorization')) : null;

        if (!$idToken) {
            return response()->json(['error' => 'Token não fornecido'], 401);
        }

        $verifiedToken = $this->firebase->verifyToken($idToken);

        if (!$verifiedToken) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $uid = $verifiedToken->claims()->get('sub');

        $usuario = Usuario::where('firebase_uid', $uid)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuário não cadastrado'], 404);
        }

        return response()->json($usuario);
    }

    // Cadastro de responsável
    public function cadastrarResponsavel(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_usuario,email',
            'senha' => 'required|string|min:6',
        ]);

        $firebaseUser = $this->firebase->createUser($validated['email'], $validated['senha'], $validated['nome']);
        if (!$firebaseUser) {
            return response()->json(['error' => 'Erro ao criar usuário no Firebase'], 500);
        }

        $usuario = Usuario::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'role' => 'responsavel',
            'firebase_uid' => $firebaseUser->uid,
        ]);

        return response()->json($usuario, 201);
    }

    // Perfil do usuário logado (aluno, responsável ou funcionário)
    public function perfil(Request $request)
    {
        $uid = $request->firebase_uid;

        $usuario = Usuario::where('firebase_uid', $uid)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        return response()->json($usuario);
    }

    // Atualizar saldo do aluno (usado pelo responsável ou funcionário)
    public function updateSaldo(Request $request, $id_aluno)
    {
        $request->validate([
            'saldo' => 'required|numeric|min:0'
        ]);

        $aluno = Usuario::where('id', $id_aluno)->where('role', 'aluno')->first();
        if (!$aluno) {
            return response()->json(['error' => 'Aluno não encontrado'], 404);
        }

        $aluno->saldo = $request->saldo;
        $aluno->save();

        return response()->json(['message' => 'Saldo atualizado', 'aluno' => $aluno]);
    }

    // Listar alunos vinculados ao responsável
    public function listarAlunos(Request $request)
    {
        $uid = $request->firebase_uid;
        $responsavel = Usuario::where('firebase_uid', $uid)->where('role', 'responsavel')->first();

        if (!$responsavel) {
            return response()->json(['error' => 'Responsável não encontrado'], 404);
        }

        $alunos = Usuario::where('id_responsavel', $responsavel->id)
                         ->where('role', 'aluno')
                         ->get();

        return response()->json($alunos);
    }
}
