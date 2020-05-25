<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\personal;
use App\materia;
use Faker\Generator as Faker;

$factory->define(App\personal_materia::class, function (Faker $faker) {
    
 	$id_personal = $faker->unique()->numberBetween(1,personal::count());
	$id_materia = $faker->numberBetween(1,materia::count());

    return [
        'id_personal'=> $id_personal,
        'id_materia'=> $id_materia,
        'tipo'=> $faker->randomElement(['titular','suplente']),
        'fecha_alta'=> $faker->date(),
        'fecha_baja'=> $faker->date(),
        'suplente_de' => 1,
    ];
});
