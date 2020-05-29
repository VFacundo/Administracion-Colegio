<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\personal;
use App\tipo_personal;
use Faker\Generator as Faker;

$factory->define(App\personal_tipo::class, function (Faker $faker) {

	$id_personal = $faker->numberBetween(1,personal::count());
	//$id_tipo_personal = $faker->numberBetween(1,tipo_personal::count());

    return [
        'id_personal'=> $id_personal,
        'id_tipo_personal'=> 1,
        'fecha_desde'=> $faker->date(),
        'fecha_hasta'=> null
    ];
});
