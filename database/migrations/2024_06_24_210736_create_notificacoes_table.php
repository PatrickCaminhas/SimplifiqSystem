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
        if (!Schema::hasTable('notificacoes')) {

        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('mensagem',100);
            $table->string('remetente',50);
            $table->string('destinatario',50);
            $table->string('lido',3)->default('nao');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
