<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('mensagens')) {
            Schema::create('mensagens', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->string('mensagem');
                $table->string('remetente');
                $table->string('destinatario');
                $table->string('lido')->default('nao');
                $table->string('is_reply')->default('nao');
                $table->string('reply_id')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};
