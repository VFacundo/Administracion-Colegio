<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\horario_materia::class, function (Faker $faker) {
    return [
       'hora_inicio' => $faker->time(),
       'hora_fin' => $faker->time(),
       'dia_semana'=> $faker->randomElement(['lunes','martes','miercoles','jueves', 'viernes'])
    ];
});
