<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Persona;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {


	//$id_persona = App\Persona::all()->unique()->random()->id;
	$id_persona = $faker->unique()->numberBetween(1,Persona::count());
	$persona = Persona::findOrFail($id_persona);

    return [

        'name' => $persona['legajo'],
        'email' => $persona['nombre_persona'] . $persona['apellido_persona'] . '@gmail.com',
        'email_verified_at' => now(),
        'password' => $persona['dni_persona'], 
        'id_persona'=> $id_persona,
        'estado_usuario'=> $faker->randomElement(['activo','inactivo']),
        'remember_token' => Str::random(10),
    ];
});
