<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
            //$table->id();
            $table->string('nombre_rol');
            $table->string('descripcion_rol');
            $table->primary('nombre_rol');
            $table->enum('estado_rol',['inactivo','activo']);
            /*
            $table->string('nombre_permiso');
            $table->foreign('nombre_permiso')->references('nombre_permiso')->on('permisos');
            */
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
        Schema::dropIfExists('rols');
    }
}
