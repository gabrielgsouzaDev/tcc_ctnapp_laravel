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
        Schema::create('responsaveis', function (Blueprint $table) {
    $table->id();
    $table->string('nome',100);
    $table->string('email',100)->unique()->nullable();
    $table->string('senha_hash',255);
    $table->string('uid_firebase',128)->unique()->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};
