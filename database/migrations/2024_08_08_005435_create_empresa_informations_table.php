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
        if (!Schema::hasTable('empresa_informations')) {
            Schema::create('empresa_informations', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj');
            $table->string('nome');
            $table->string('tamanho_empresa');
            $table->string('tipo_empresa');
            $table->string('area_atuacao');
            $table->string('telefone');
            $table->string('estado');
            $table->string('padrao_cores');
            $table->binary('logo')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_informations');
    }
};
