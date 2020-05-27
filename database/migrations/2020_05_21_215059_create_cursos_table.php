<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->integer('anio');
            $table->string('nombre_curso');
            $table->string('division');
            $table->string('aula');
            $table->unsignedBigInteger('id_ciclo_lectivo');
            $table->foreign('id_ciclo_lectivo')->references('id')->on('ciclo_lectivos');
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
        Schema::dropIfExists('cursos');
    }
}
