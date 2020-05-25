<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\pregunta::class, function (Faker $faker) {
    return [
        'item' => Str::random(4),
        'respuesta' => Str::random(4)
    ];
});
