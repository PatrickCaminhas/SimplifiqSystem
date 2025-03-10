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
        if (!Schema::hasTable('estoque')) {
            Schema::create('estoque', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produto');
            $table->integer('quantidade');
            $table->string('acao');
            $table->integer('mes');
            $table->string('ano');
            $table->string('usuario');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque');
    }
};
