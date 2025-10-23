<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ResponsavelController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CantinaController;
use App\Http\Controllers\PlanoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aqui definimos rotas públicas e protegidas com middleware para cada tipo
| de usuário.
*/

// -------------------- ROTAS PÚBLICAS --------------------
// Login e cadastro de responsáveis
Route::post('/login-responsavel', [ResponsavelController::class, 'login']);
Route::post('/cadastrar-responsavel', [ResponsavelController::class, 'cadastrar']);

// Login de alunos
Route::post('/login-aluno', [AlunoController::class, 'login']);

// Cadastro de admin
Route::post('/cadastrar-admin', [AdminController::class, 'cadastrarAdmin']);

// -------------------- ROTAS PROTEGIDAS: FIREBASE --------------------
// Usuário precisa estar autenticado via Firebase
Route::middleware(['firebase.auth'])->group(function () {

    // ---------- RESPONSÁVEL ----------
    Route::get('/alunos', [AlunoController::class, 'listarAlunos']); // Lista alunos do responsável
    Route::post('/pedido', [PedidoController::class, 'fazerPedido']); // Criar pedido
    Route::get('/historico/{id_aluno}', [PedidoController::class, 'historicoPedidos']); // Histórico do aluno
    Route::post('/update-saldo', [PedidoController::class, 'updateSaldo']); // Atualizar saldo do aluno

    // ---------- ALUNO ----------
    Route::get('/saldo/{id_aluno}', [AlunoController::class, 'getSaldo']); // Consultar saldo
});

// -------------------- ROTAS PROTEGIDAS: ADMIN --------------------
// Admin logado (pode usar middleware próprio ou auth:api)
Route::middleware(['auth:api'])->group(function () {

    // Admin
    Route::post('/login-admin', [AdminController::class, 'login']);
    Route::get('/admins', [AdminController::class, 'listarAdmins']);

    // Planos
    Route::get('/planos', [PlanoController::class, 'listarPlanos']);
    Route::get('/plano/{id_plano}', [PlanoController::class, 'buscarPlano']);
    Route::post('/plano', [PlanoController::class, 'cadastrarPlano']);

    // Escolas, Cantinas e Produtos
    Route::get('/cantinas/{id_escola}', [CantinaController::class, 'listarCantinas']);
    Route::get('/produtos/{id_cantina}', [ProdutoController::class, 'listarProdutos']);
});
