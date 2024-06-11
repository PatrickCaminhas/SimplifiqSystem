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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('nome',30);
            $table->string('sobrenome',70);
            $table->string('email',100)->unique();
            $table->string('empresas')->foreign('cnpj')->references('cnpj')->on('empresas')->onDelete('cascade');
            $table->string('senha',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
