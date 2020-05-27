<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Alumno;
use App\Curso;
use Faker\Generator as Faker;

$factory->define(App\alumno_curso::class, function (Faker $faker) {

	$id_alumno = $faker->numberBetween(1,Alumno::count());
	$id_curso = $faker->numberBetween(1,Curso::count());

    return [
			
		'id_alumno' => $id_alumno,
		'id_curso' => $id_curso	        
    ];
});
