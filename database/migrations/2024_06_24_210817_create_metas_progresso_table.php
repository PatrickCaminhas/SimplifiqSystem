<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('metas_progressos')) {
            Schema::create('metas_progressos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('meta_id');
                $table->decimal('valor', 6, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas_progressos');
    }
};
