<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->string('descripcion');
            $table->date('fecha_origen');
            $table->date('fecha_visto')->nullable();
            $table->enum('estado_notificacion',['inactivo','activo']);
            $table->unsignedBigInteger('usuarios_destino');
            $table->unsignedBigInteger('usuarios_generador');
            $table->foreign('usuarios_destino')->references('id')->on('users');
            $table->foreign('usuarios_generador')->references('id')->on('users');

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
        Schema::dropIfExists('notificacions');
    }
}
