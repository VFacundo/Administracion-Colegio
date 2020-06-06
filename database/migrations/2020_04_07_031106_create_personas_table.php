<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            //$table->string('legajo')->unique()->nullable;
            $table->string('nombre_persona');
            $table->string('apellido_persona');
            $table->unsignedBigInteger('tipo_documento');
            $table->string('dni_persona');
            $table->string('cuil_persona');
            $table->string('domicilio');
            $table->date('fecha_nacimiento');
            $table->string('numero_telefono');
            $table->enum('estado_persona',['inactivo','activo']);
            //$table->primary('id');//PrimaryKey
            $table->foreign('tipo_documento')->references('id')->on('tipo_documentos');
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
        Schema::dropIfExists('personas');
    }
}
