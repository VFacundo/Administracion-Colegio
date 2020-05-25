<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\curso::class, function (Faker $faker) {
    return [
        'anio' => '2020',
        'nombre_curso' =>$faker->unique()->randomElement(['primero','segundo', 'tercero', 'cuarto', 'quinto', 'sexto']),
        'division'=> $faker->randomElement(['A','B']),
        'aula' => $faker->unique()->numberBetween(1,10)
    ];
});
