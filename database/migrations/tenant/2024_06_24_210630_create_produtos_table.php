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
        if (!Schema::hasTable('produtos')) {

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 100);
            $table->string("marca", 50);
            $table->string("modelo", 50);
            $table->string("categoria", 50);
            $table->string("unidade_medida", 20);
            $table->integer("medida");
            $table->string("descricao", 200);
            $table->integer("quantidade");
            $table->string("ultimo_fornecedor", 100);
            $table->decimal('preco_compra', 6,2);
            $table->decimal('preco_venda', 6,2);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
