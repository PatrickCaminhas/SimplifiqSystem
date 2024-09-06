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
        if (!Schema::hasTable('itens_vendas')) {
            Schema::create('itens_vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained();
            $table->foreignId('produto_id')->constrained();
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_vendas');
    }
};
