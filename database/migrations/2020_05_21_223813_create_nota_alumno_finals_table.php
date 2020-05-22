<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaAlumnoFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_alumno_finals', function (Blueprint $table) {
            $table->id();
            $table->integer('id_materia');
            $table->double('nota_primer_trimestre');
            $table->double('nota_segundo_trimestre');
            $table->double('nota_tercer_trimestre');
            $table->double('nota_final');
            $table->unsignedBigInteger('id_alumno_curso');
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
        Schema::dropIfExists('nota_alumno_finals');
    }
}
