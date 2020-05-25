<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\alumno_curso;
use App\tipo_nota;
use App\materia;
use Faker\Generator as Faker;

$factory->define(App\nota_alumno::class, function (Faker $faker) {

	$id_alumno_curso = $faker->numberBetween(1,alumno_curso::count());
	$id_tipo_nota = $faker->numberBetween(1,tipo_nota::count());
	$id_materia = $faker->numberBetween(1,materia::count());

    return [
    	'id_materia' => $id_materia,
        'nota' => $faker->numberBetween(1,10),
        'comentario' => 'Esto es una nota de prueba',
        'trimestre' => $faker->numberBetween(1,3),
        'id_alumno_curso' => $id_alumno_curso,
        'id_tipo_nota' => $id_tipo_nota
    ];
});
