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
        Schema::create('escolas', function (Blueprint $table) {
    $table->id();
    $table->string('nome',150);
    $table->string('cnpj',20)->unique()->nullable();
    $table->foreignId('id_endereco')->nullable()->constrained('enderecos');
    $table->foreignId('id_plano')->nullable()->constrained('planos');
    $table->enum('status',['ativa','inativa'])->default('ativa');
    $table->integer('qtd_alunos')->default(0);
    $table->string('email_contato',100)->nullable();
    $table->string('senha_hash',255);
    $table->string('nm_gerente',100)->nullable();
    $table->string('telefone_contato',20)->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escolas');
    }
};
