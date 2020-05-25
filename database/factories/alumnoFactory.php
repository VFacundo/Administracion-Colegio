<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Persona;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\alumno::class, function (Faker $faker) {

	$id_persona = $faker->unique()->numberBetween(1,Persona::count());
	$id_tutor = $faker->unique()->numberBetween(1,Persona::count());
	$persona = Persona::findOrFail($id_persona);

    return [
        'legajo_alumno'=>$faker->unique()->numberBetween(1,9999),
        'persona_asociada'=> $id_persona,
        'id_calendario'=> 1,
        'persona_tutor'=> $id_tutor

    ];
});
