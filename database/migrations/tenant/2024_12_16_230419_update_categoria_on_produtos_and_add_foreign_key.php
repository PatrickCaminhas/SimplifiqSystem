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
        Schema::table('produtos', function (Blueprint $table) {
            $table->renameColumn('categoria', 'categoria_id');
            // 1. Permite que o campo categoria seja NULL e muda para unsignedBigInteger
            $table->unsignedBigInteger('categoria')->nullable()->change();

            // 2. Cria a chave estrangeira referenciando produtos_categoria
            $table->foreign('categoria')
                ->references('id')
                ->on('produtos_categoria')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['categoria']);

            // Reverte o campo categoria para NOT NULL e string (ou o tipo original)
            $table->string('categoria')->change();
        });
    }
};
