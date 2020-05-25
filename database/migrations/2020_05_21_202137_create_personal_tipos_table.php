<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_tipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_tipo_personal');
            $table->date('fecha_desde');
            $table->date('fecha_hasta')->nullable();
            $table->foreign('id_personal')->references('id')->on('personals');
            $table->foreign('id_tipo_personal')->references('id')->on('tipo_personals');
            
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
        Schema::dropIfExists('personal_tipos');
    }
}
