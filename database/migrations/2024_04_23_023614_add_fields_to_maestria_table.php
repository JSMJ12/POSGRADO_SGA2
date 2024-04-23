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
            $table->decimal('inscripcion', 8, 2)->after('nombre')->nullable();
            $table->decimal('matricula', 8, 2)->after('inscripcion')->nullable();
            $table->decimal('arancel', 8, 2)->after('matricula')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maestrias', function (Blueprint $table) {
            $table->dropColumn('inscripcion');
            $table->dropColumn('matricula');
            $table->dropColumn('arancel');
        });
    }
};
