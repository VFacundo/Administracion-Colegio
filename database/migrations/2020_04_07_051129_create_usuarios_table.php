<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('id');
            $table->string('legajo');
            $table->string('username');
            $table->string('password');
            $table->string('mail');

            $table->unique('legajo');

            $table->unsignedBigInteger('id_persona');

            /*
            $table->string('nombre_rol');
            $table->foreign('nombre_rol')->references('nombre_rol')->on('rols');
            */

            $table->foreign('id_persona')->references('id')->on('personas');

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
        Schema::dropIfExists('usuarios');
    }
}
