<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\curso;
use App\materia;
use App\horario_materia;
use Faker\Generator as Faker;

$factory->define(App\materia_curso::class, function (Faker $faker) {
    
    $id_curso = $faker->numberBetween(1,curso::count());
    $id_materia = $faker->numberBetween(1,materia::count());
    $id_horario_materia = $faker->numberBetween(1,horario_materia::count());

    return [

    	'id_curso' => $id_curso,
    	'id_materia'=> $id_materia,
        
    ];
});
