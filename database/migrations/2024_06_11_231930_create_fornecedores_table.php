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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome',100);
            $table->string('CNPJ',18)->unique();
            $table->string('endereco',100);
            $table->string('cidade',50);
            $table->string('estado',2);
            $table->string('nome_representante',100);
            $table->string('email',100);
            $table->string('telefone',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
