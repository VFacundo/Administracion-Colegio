<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramaMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_archivo');
            $table->string('localizacion_archivo');
            $table->date('fecha_subida');
            $table->date('vigente_desde');
            $table->date('vigente_hasta');
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
        Schema::dropIfExists('programa_materias');
    }
}
