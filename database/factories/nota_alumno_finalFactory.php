<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\alumno_curso;
use Faker\Generator as Faker;

$factory->define(App\nota_alumno_final::class, function (Faker $faker) {

	$id_alumno_curso = $faker->numberBetween(1,alumno_curso::count());

	//con pocos datos tira error el unique

    return [
        'id_materia' => $faker->numberBetween(1,10),
        'nota_primer_trimestre' => $faker->numberBetween(1,10),
        'nota_segundo_trimestre' => $faker->numberBetween(1,10),
        'nota_tercer_trimestre' => $faker->numberBetween(1,10),
        'nota_final' => $faker->numberBetween(1,10),
        'id_alumno_curso' => $id_alumno_curso
    ];
});
