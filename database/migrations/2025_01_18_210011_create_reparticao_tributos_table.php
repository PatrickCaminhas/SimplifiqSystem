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
        Schema::create('reparticao_tributos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cpp', 5, 2);
            $table->decimal('csll', 5, 2);
            $table->decimal('icms', 5, 2);
            $table->decimal('irpj', 5, 2);
            $table->decimal('cofins', 5, 2);
            $table->string('faixa', 50);
            $table->decimal('pis_pasep', 5, 2);
            $table->timestamps();
        });
        DB::table('reparticao_tributos')->insert([
            ['cpp' => 41.50, 'csll' => 3.50, 'icms' => 34.00, 'irpj' => 5.50, 'cofins' => 12.74, 'faixa' => 'Faixa 1', 'pis_pasep' => 2.76, 'created_at' => now(), 'updated_at' => now()],
            ['cpp' => 41.50, 'csll' => 3.50, 'icms' => 34.00, 'irpj' => 5.50, 'cofins' => 12.74, 'faixa' => 'Faixa 2', 'pis_pasep' => 2.76, 'created_at' => now(), 'updated_at' => now()],
            ['cpp' => 42.00, 'csll' => 3.50, 'icms' => 33.50, 'irpj' => 5.50, 'cofins' => 12.74, 'faixa' => 'Faixa 3', 'pis_pasep' => 2.76, 'created_at' => now(), 'updated_at' => now()],
            ['cpp' => 42.00, 'csll' => 3.50, 'icms' => 33.50, 'irpj' => 5.50, 'cofins' => 12.74, 'faixa' => 'Faixa 4', 'pis_pasep' => 2.76, 'created_at' => now(), 'updated_at' => now()],
            ['cpp' => 42.00, 'csll' => 3.50, 'icms' => 33.50, 'irpj' => 5.50, 'cofins' => 12.74, 'faixa' => 'Faixa 5', 'pis_pasep' => 2.76, 'created_at' => now(), 'updated_at' => now()],
            ['cpp' => 42.10, 'csll' => 10.00, 'icms' => 0.00, 'irpj' => 13.50, 'cofins' => 28.27, 'faixa' => 'Faixa 6', 'pis_pasep' => 6.13, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparticao_tributos');
    }
};
