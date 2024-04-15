<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->integer('registro')->default(1);
        });
    }

    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('registro');
        });
    }
};
