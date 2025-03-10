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
        //
        DB::table('clientes')->insert([
            'nome' => 'Cliente Não cadastrado',
            'cpfOuCnpj' => 'XX.XXX.XXX/XXXX-XX',
            'email' => 'clientenaocadastrado@simplifiq.com',
            'endereco_completo' => 'Não cadastrado',
            'telefone' => 'Não cadastrado',
            'crediario' => 0,
            'debitos' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
