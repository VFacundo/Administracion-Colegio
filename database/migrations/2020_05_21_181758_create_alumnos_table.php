<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('legajo_alumno');
            $table->unsignedBigInteger('persona_asociada'); 
            $table->unsignedBigInteger('persona_tutor');
            $table->date('fecha_baja')->nullable();
            $table->foreign('persona_tutor')->references('id')->on('responsables');
            $table->foreign('persona_asociada')->references('id')->on('personas');
           

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
        Schema::dropIfExists('alumnos');
    }
}
