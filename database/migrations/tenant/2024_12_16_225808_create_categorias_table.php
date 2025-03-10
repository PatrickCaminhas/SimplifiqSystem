<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos_categoria', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });
                // Inserção da tupla com dados iniciais

        DB::table('produtos_categoria')->insert([
            'nome' => 'Sem categoria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_categoria'); // Corrigido
    }

};
