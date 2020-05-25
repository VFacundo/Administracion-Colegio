<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\persona::class, function (Faker $faker) {

	$dni = $faker->unique()->numberBetween(1,99999999);
	$cuil = $faker->numberBetween(21,27) . $dni . $faker->numberBetween(1,9);
    return [
    	'legajo'=> $faker->unique()->numberBetween(1,999999),
        'nombre_persona' => $faker->firstname($gender=null),
        'apellido_persona' => $faker->lastname,
        'tipo_documento' => App\tipo_documento::all()->random()->id,
        'dni_persona'=> $dni,
        'cuil_persona'=> $cuil,
        'domicilio'=> $faker->streetAddress,
        'fecha_nacimiento'=> $faker->date(),
        'numero_telefono'=> $faker->e164PhoneNumber,
        'estado_persona'=> $faker->randomElement(['activo','inactivo'])

    ];
});
