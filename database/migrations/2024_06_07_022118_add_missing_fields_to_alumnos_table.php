<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('celular')->nullable();
            $table->string('titulo_profesional')->nullable();
            $table->string('universidad_titulo')->nullable();
            $table->string('tipo_colegio')->nullable();
            $table->integer('cantidad_miembros_hogar')->nullable();
            $table->decimal('ingreso_total_hogar', 10, 2)->nullable();
            $table->string('nivel_formacion_padre')->nullable();
            $table->string('nivel_formacion_madre')->nullable();
            $table->string('origen_recursos_estudios')->nullable();
            $table->string('pdf_cedula')->nullable();
            $table->string('pdf_papelvotacion')->nullable();
            $table->string('pdf_titulouniversidad')->nullable();
            $table->string('pdf_conadis')->nullable();
            $table->string('pdf_hojavida')->nullable();
            $table->string('carta_aceptacion')->nullable();
            $table->string('pago_matricula')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn([
                'celular',
                'titulo_profesional',
                'universidad_titulo',
                'nacionalidad_indigena',
                'tipo_colegio',
                'cantidad_miembros_hogar',
                'ingreso_total_hogar',
                'nivel_formacion_padre',
                'nivel_formacion_madre',
                'origen_recursos_estudios',
                'pdf_cedula',
                'pdf_papelvotacion',
                'pdf_titulouniversidad',
                'pdf_conadis',
                'pdf_hojavida',
                'status',
                'carta_aceptacion',
                'pago_matricula',
            ]);
        });
    }
}
