<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('id_aluno')->constrained('alunos');
    $table->foreignId('id_responsavel')->nullable()->constrained('responsaveis');
    $table->foreignId('id_cantina')->constrained('cantinas');
    $table->enum('status',['pendente','confirmado','entregue','cancelado'])->default('pendente');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
