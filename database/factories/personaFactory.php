<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Factory as Faker;

$factory->define(App\Persona::class, function () {
//$faker->addProvider(new Faker\Provider\es_PE\Person($faker));
	$faker = Faker::create('es_PE');
	$dni = $faker->dni;
	$cuil = $faker->numberBetween(21,27) . $dni . $faker->numberBetween(1,9);
    return [
    		//'legajo'=> $faker->numberBetween(1,999999),
        'nombre_persona' => $faker->firstname($gender=null),
        'apellido_persona' => $faker->lastname,
        'tipo_documento' => App\tipo_documento::all()->random()->id,
        'dni_persona'=> $dni,
        'cuil_persona'=> $cuil,
        'domicilio'=> $faker->streetAddress,
        'fecha_nacimiento'=> $faker->date(),
        'numero_telefono'=> substr($faker->e164PhoneNumber, 1),
        'estado_persona'=> $faker->randomElement(['activo','inactivo'])

    ];
});
