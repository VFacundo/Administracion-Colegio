<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_curso');
            $table->date('fecha_creacion');
            $table->date('fecha_resolucion');
            $table->unsignedBigInteger('id_encuestado');
            $table->unsignedBigInteger('id_encuestador');
            $table->enum('objetivo',['Alumnos','Docentes', 'Todos']);
            $table->foreign('id_curso')->references('id')->on('cursos');
            $table->foreign('id_encuestado')->references('id')->on('users');
            $table->foreign('id_encuestador')->references('id')->on('users');
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
        Schema::dropIfExists('encuestas');
    }
}
