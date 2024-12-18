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
            // Renomeia a coluna 'categoria' para 'categoria_id'
            $table->unsignedBigInteger('categoria')->nullable()->change();

            $table->renameColumn('categoria', 'categoria_id');

            // Modifica 'categoria_id' para unsignedBigInteger e permite NULL


            // Cria a chave estrangeira referenciando 'produtos_categoria'
            $table->foreign('categoria_id')
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
            $table->dropForeign(['categoria_id']);

            // Reverte 'categoria_id' para string e NOT NULL (ou o tipo original)
            $table->string('categoria_id')->change();

            // Renomeia a coluna de volta para 'categoria'
            $table->renameColumn('categoria_id', 'categoria');
        });
    }
};
