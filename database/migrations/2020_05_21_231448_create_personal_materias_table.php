<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_materias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_materia');
            $table->enum('tipo',['titular','suplente']);
            $table->date('fecha_alta');
            $table->date('fecha_baja');
            $table->unsignedBigInteger('suplente_de');
            $table->foreign('id_personal')->references('id')->on('personals');
            $table->foreign('id_materia')->references('id')->on('materias');
            $table->foreign('suplente_de')->references('id')->on('personals');
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
        Schema::dropIfExists('personal_materias');
    }
}
