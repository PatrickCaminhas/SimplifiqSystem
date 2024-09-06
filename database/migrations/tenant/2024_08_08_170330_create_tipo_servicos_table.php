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
        if (!Schema::hasTable('tipo_servicos')) {
            Schema::create('tipo_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('categoria');
            $table->decimal('duracao',5,2);
            $table->string('materiais');
            $table->integer('quantidade_de_funcionarios');
            $table->decimal('valor',6,2);
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_servicos');
    }
};
