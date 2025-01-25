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
        // Criação da tabela
        Schema::create('simples_nacionals', function (Blueprint $table) {
            $table->id();
            $table->string('nome_anexo');
            $table->string('faixa_anexo');
            $table->decimal('receita_bruta_anual_min', 11, 2);
            $table->decimal('receita_bruta_anual_max', 11, 2);
            $table->decimal('aliquota', 4, 2);
            $table->decimal('deducao', 10, 2);
            $table->timestamps();
        });

        // Inserção dos dados do Anexo I
        DB::table('simples_nacionals')->insert([
            //DATA: JAN/2025
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 1',
                'receita_bruta_anual_min' => 0.00,
                'receita_bruta_anual_max' => 180000.00,
                'aliquota' => 4.00,
                'deducao' => 0.00,
            ],
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 2',
                'receita_bruta_anual_min' => 180000.01,
                'receita_bruta_anual_max' => 360000.00,
                'aliquota' => 7.30,
                'deducao' => 5940.00,
            ],
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 3',
                'receita_bruta_anual_min' => 360000.01,
                'receita_bruta_anual_max' => 720000.00,
                'aliquota' => 9.50,
                'deducao' => 13860.00,
            ],
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 4',
                'receita_bruta_anual_min' => 720000.01,
                'receita_bruta_anual_max' => 1800000.00,
                'aliquota' => 10.70,
                'deducao' => 22500.00,
            ],
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 5',
                'receita_bruta_anual_min' => 1800000.01,
                'receita_bruta_anual_max' => 3600000.00,
                'aliquota' => 14.30,
                'deducao' => 87300.00,
            ],
            [
                'nome_anexo' => 'Anexo I',
                'faixa_anexo' => 'Faixa 6',
                'receita_bruta_anual_min' => 3600000.01,
                'receita_bruta_anual_max' => 4800000.00,
                'aliquota' => 19.00,
                'deducao' => 378000.00,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Exclusão da tabela
        Schema::dropIfExists('simples_nacionals');
    }
};
