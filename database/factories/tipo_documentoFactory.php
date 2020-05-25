<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\tipo_documento::class, function (Faker $faker) {
    return [
        'nombre_tipo' => $faker->sentence,
        'descripcion' => $faker->sentence
    ];
});
