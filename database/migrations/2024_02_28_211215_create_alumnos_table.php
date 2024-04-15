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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->string('dni')->primary();
            $table->string('nombre1')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('apellidop')->nullable();
            $table->string('apellidom')->nullable();
            $table->string('estado_civil')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('provincia')->nullable();
            $table->string('canton')->nullable();
            $table->string('barrio')->nullable();
            $table->string('direccion')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('etnia')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('email_institucional')->nullable();
            $table->string('carnet_discapacidad')->nullable();
            $table->string('tipo_discapacidad')->nullable();
            $table->decimal('porcentaje_discapacidad', 4, 1)->nullable();
            $table->string('contra')->nullable();
            $table->string('image')->nullable();
            $table->char('sexo', 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
