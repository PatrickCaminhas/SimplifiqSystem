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
        if (!Schema::hasTable('servicos')) {
            Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_cliente');
            $table->string('identificacao_cliente');
            $table->string('tipo_cliente');
            $table->string('valor');
            $table->string('tipo_servico');
            $table->integer('quantidade_tarefas');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('estado');
            $table->string('descricao');
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
