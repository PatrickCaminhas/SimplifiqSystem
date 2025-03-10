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
        if (Schema::hasColumn('servicos', 'quantidade_tarefas')) {
            Schema::table('servicos', function (Blueprint $table) {
                $table->dropColumn('quantidade_tarefas');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('servicos', 'quantidade_tarefas')) {
            Schema::table('servicos', function (Blueprint $table) {
                $table->integer('quantidade_tarefas')->nullable(); // Ajuste o tipo conforme a coluna original
            });
        }
    }
};

