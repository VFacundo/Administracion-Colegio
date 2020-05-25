<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\user;
use Faker\Generator as Faker;

$factory->define(App\notificacion::class, function (Faker $faker) {

	$id_generador = $faker->numberBetween(1,User::count());
	$id_destino = $faker->numberBetween(1,User::count());


    return [
        'motivo' => Str::random(10),
        'descripcion' => Str::random(10),
        'fecha_origen' => $faker->date(),
        'fecha_visto' => $faker->date(),
        'estado_notificacion'=> $faker->randomElement(['activo','inactivo']),
        'usuarios_destino' => $id_destino,
        'usuarios_generador' => $id_generador



    ];
});
