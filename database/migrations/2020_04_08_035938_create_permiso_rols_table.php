<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_rols', function (Blueprint $table) {
            //$table->id();
            $table->unsignedBigInteger('id_permiso');
            $table->String('nombre_rol');
            $table->Date('fecha_asignacion_permiso');
            $table->primary(['id_permiso','nombre_rol']);

            $table->foreign('nombre_rol')->references('nombre_rol')->on('rols');
            $table->foreign('id_permiso')->references('id')->on('permisos');

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
        Schema::dropIfExists('permiso_rols');
    }
}
