<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_alumnos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_materia');
            $table->double('nota');
            $table->string('comentario');
            $table->integer('trimestre');
            $table->unsignedBigInteger('id_alumno_curso');
            $table->unsignedBigInteger('id_tipo_nota');
            $table->foreign('id_tipo_nota')->references('id')->on('tipo_notas');
            $table->foreign('id_alumno_curso')->references('id')->on('alumno_cursos');

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
        Schema::dropIfExists('nota_alumnos');
    }
}
