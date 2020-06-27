<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicloLectivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciclo_lectivos', function (Blueprint $table) {
            $table->id();
            $table->year('anio');
            $table->string('nombre');
            $table->date('fecha_baja')->nullable();
            $table->enum('estado',['inicial','primer_trimestre','segundo_trimestre','tercer_trimestre','finalizado']);
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
        Schema::dropIfExists('ciclo_lectivos');
    }
}
