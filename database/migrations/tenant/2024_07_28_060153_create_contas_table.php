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
        if (!Schema::hasTable('contas')) {
            Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('credor');
            $table->decimal('valor', 10, 2);
            $table->string('tipo');
            $table->date('data_vencimento');
            $table->string('estado');
            $table->date('data_pagamento')->nullable();
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
