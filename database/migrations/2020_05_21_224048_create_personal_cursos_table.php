<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_curso');
            $table->unsignedBigInteger('id_personal');
            $table->foreign('id_personal')->references('id')->on('personals');
            $table->foreign('id_curso')->references('id')->on('cursos');
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
        Schema::dropIfExists('personal_cursos');
    }
}
