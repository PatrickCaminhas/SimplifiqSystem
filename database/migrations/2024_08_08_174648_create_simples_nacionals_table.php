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
        Schema::create('simples_nacionals', function (Blueprint $table) {
            $table->id();
            $table->string('nome_anexo');
            $table->string('faixa_anexo');
            $table->decimal('receita_bruta_anual_min',11,2);
            $table->decimal('receita_bruta_anual_max',11,2);
            $table->decimal('aliquota', 4, 2);
            $table->decimal('deducao',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simples_nacionals');
    }
};
