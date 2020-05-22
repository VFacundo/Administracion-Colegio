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
            $table->unsignedBigInteger('id_calendario');
            $table->unsignedBigInteger('persona_tutor');
            $table->foreign('persona_tutor')->references('id')->on('users');
            $table->foreign('persona_asociada')->references('id')->on('users');
            $table->foreign('id_calendario')->references('id')->on('calendarios');

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
