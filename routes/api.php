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
| Rotas públicas e protegidas (middleware) para cada tipo de usuário.
*/

// -------------------- PUBLICAS --------------------
// Login e cadastro
Route::post('/login-responsavel', [ResponsavelController::class,'login']);
Route::post('/cadastrar-responsavel', [ResponsavelController::class,'cadastrar']);

Route::post('/login-aluno', [AlunoController::class,'login']);
Route::post('/cadastrar-admin', [AdminController::class,'cadastrarAdmin']);

// -------------------- MIDDLEWARE FIREBASE --------------------
// Usuário precisa estar autenticado via token Firebase
Route::middleware(['firebase.auth'])->group(function() {

    // ---------- RESPONSÁVEL ----------
    Route::get('/alunos', [AlunoController::class,'listarAlunos']);
    Route::post('/pedido', [PedidoController::class,'fazerPedido']);
    Route::get('/historico/{id_aluno}', [PedidoController::class,'historicoPedidos']);
    Route::post('/update-saldo', [PedidoController::class,'updateSaldo']);

    // ---------- ALUNO ----------
    Route::get('/saldo/{id_aluno}', [AlunoController::class,'getSaldo']);

});

// -------------------- MIDDLEWARE ADMIN --------------------
// Admin logado (middleware próprio pode ser criado)
Route::middleware(['auth:api'])->group(function() {

    // Admin
    Route::post('/login-admin', [AdminController::class,'login']);
    Route::get('/admins', [AdminController::class,'listarAdmins']);

    // Plano
    Route::get('/planos', [PlanoController::class,'listarPlanos']);
    Route::get('/plano/{id_plano}', [PlanoController::class,'buscarPlano']);
    Route::post('/plano', [PlanoController::class,'cadastrarPlano']);

    // Escolas, Cantinas e Cantineiros
    Route::get('/cantinas/{id_escola}', [CantinaController::class,'listarCantinas']);
    Route::get('/produtos/{id_cantina}', [ProdutoController::class,'listarProdutos']);

});
