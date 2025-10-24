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
        Schema::create('tb_aluno_responsavel', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_aluno');
    $table->unsignedBigInteger('id_responsavel');
    $table->timestamps();

    $table->foreign('id_aluno')->references('id_aluno')->on('tb_aluno')->onDelete('cascade');
    $table->foreign('id_responsavel')->references('id_responsavel')->on('tb_responsavel')->onDelete('cascade');
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
