<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MateriaHorario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_horario');
            $table->unsignedBigInteger('id_materia_curso');
            $table->foreign('id_horario')->references('id')->on('horario_materias');
            $table->foreign('id_materia_curso')->references('id')->on('materia_cursos');


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
        Schema::dropIfExists('materia_horarios');
    }
}
