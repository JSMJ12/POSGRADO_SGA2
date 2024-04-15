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
        Schema::table('maestrias', function (Blueprint $table) {
            $table->decimal('precio_total')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maestrias', function (Blueprint $table) {
            $table->dropColumn(['precio_total', 'fecha_inicio', 'fecha_fin']);
        });
    }
};
