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
        Schema::table('postulantes', function (Blueprint $table) {
            $table->boolean('status')->default(false)->comment('Indica si el postulante ha sido aceptado');
            $table->string('pago_matricula')->nullable()->comment('Almacena el comprobante de pago de matrícula');
        });
    }

    public function down()
    {
        Schema::table('postulantes', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('pago_matricula');
        });
    }
};
