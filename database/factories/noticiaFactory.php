<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\noticia::class, function (Faker $faker) {

	$id_usuario_generador = $faker->numberBetween(1,User::count());

    return [
        'descripcion_noticia' => $faker->text(),
        'titulo_noticia' => Str::random(5),
        'fecha_origen' => $faker->date(),
        'noticias_usuarios_generador'=> $id_usuario_generador

    ];
});
