<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\curso::class, function (Faker $faker) {
    return [
        'anio' => '2020',
        'nombre_curso' =>$faker->randomElement(['Primero','Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto']),
        'division'=> $faker->randomElement(['A','B']),
        'aula' => $faker->unique()->numberBetween(1,100),
        'id_ciclo_lectivo' => 1,
    ];
});
