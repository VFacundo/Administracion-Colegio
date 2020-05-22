<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('anio');
            $table->integer('mes_numero');
            $table->integer('dia_numero');
            $table->string('mes_nombre');
            $table->unsignedBigInteger('asistencia');
            $table->foreign('asistencia')->references('id')->on('asistencias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendarios');
    }
}
