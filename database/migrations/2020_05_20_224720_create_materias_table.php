<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('carga_horaria');
            $table->date('fecha_creacion');
            $table->date('fecha_baja')->nullable();
            $table->unsignedBigInteger('programa_materia');
            $table->enum('estado_materia',['inactivo','activo']);
            $table->string('curso_correspondiente');
            $table->foreign('programa_materia')->references('id')->on('programa_materias');

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
        Schema::dropIfExists('materias');
    }
}
