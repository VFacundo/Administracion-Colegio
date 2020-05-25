<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Persona;
use Faker\Generator as Faker;

$factory->define(App\personal::class, function (Faker $faker) {
	
	$id_persona = $faker->unique()->numberBetween(11,Persona::count());

    return [
        'id_persona'=> $id_persona,
        'fecha_alta'=> $faker->date(),
        'fecha_baja'=> $faker->date(),
        'manejo_de_grupo'=> $faker->randomElement(['excelente','bueno', 'regular', 'malo']),
        'legajo_personal'=>$faker->unique()->numberBetween(10000,19999),


    ];
});
