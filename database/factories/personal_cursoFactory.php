<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\personal;
use App\curso;
use Faker\Generator as Faker;

$factory->define(App\personal_curso::class, function (Faker $faker) {
    
    $id_personal = $faker->numberBetween(1,personal::count());
	$id_curso = $faker->numberBetween(1,curso::count());

    return [
    	'id_curso'=> $id_curso,
        'id_personal'=> $id_personal
        
    ];
});
