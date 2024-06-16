<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoDiscapacidadAndCartaAceptacionToPostulantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postulantes', function (Blueprint $table) {
            $table->string('tipo_discapacidad')->nullable()->after('discapacidad');
            $table->string('carta_aceptacion')->nullable()->after('tipo_discapacidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postulantes', function (Blueprint $table) {
            $table->dropColumn('tipo_discapacidad');
            $table->dropColumn('carta_aceptacion');
        });
    }
}
