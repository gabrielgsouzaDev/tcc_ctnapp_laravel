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
        Schema::create('aluno_responsavel', function (Blueprint $table) {
    $table->foreignId('id_aluno')->constrained('alunos');
    $table->foreignId('id_responsavel')->constrained('responsaveis');
    $table->primary(['id_aluno','id_responsavel']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aluno_responsavel');
    }
};
