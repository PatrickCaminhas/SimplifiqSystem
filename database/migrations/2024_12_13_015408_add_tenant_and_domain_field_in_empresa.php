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
        Schema::table('empresas', function (Blueprint $table) {
            //
            $table->unsignedInteger('dominio')->after('estado')->nullable(); // Compatível com `increments` de `domains`.
            $table->string('tenant')->after('estado')->nullable();
            $table->foreign('tenant')->references('id')->on('tenants');
            $table->foreign('dominio')->references('id')->on('domains');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            //
        });
    }
};
