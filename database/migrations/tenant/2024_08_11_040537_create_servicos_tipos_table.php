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
        if (!Schema::hasTable('servicos_tipos')) {
            Schema::create('servicos_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('duracao');
            $table->string('materiais');
            $table->integer('quantidade_de_funcionarios');
            $table->decimal('valor_diario',4,2);
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
        Schema::dropIfExists('servicos_tipos');
    }
};
