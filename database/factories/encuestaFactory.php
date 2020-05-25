<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\curso;
use App\pregunta;
use App\user;
use Faker\Generator as Faker;

$factory->define(App\encuesta::class, function (Faker $faker) {

	$id_curso = $faker->numberBetween(1,curso::count());
	$id_pregunta = $faker->numberBetween(1,pregunta::count());
	$id_encuestado = $faker->numberBetween(1,user::count());
	$id_encuestador = $faker->numberBetween(1,user::count());


    return [
        'id_curso'=> $id_curso,
        'fecha_creacion'=> $faker->date(),
        'fecha_resolucion'=> $faker->date(),
        'id_encuestado'=> $id_encuestado,
        'id_encuestador'=> $id_encuestador,
        'objetivo'=> $faker->randomElement(['Alumnos','Docentes','Todos'])

        
    ];
});
