<?php

use Illuminate\Database\Seeder;
use App\Persona;
use Faker\Factory as Faker;

class personalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\personal::class, 10)->create();
        $faker = Faker::create();
        $personas = Persona::all();
        $cantidadPersonas = count($personas);
        $cantPersonal = ((20*$cantidadPersonas)/100);

        for($i=1;$i<$cantPersonal;$i++){
          DB::table('personals')->insert([
            'id_persona' => ($cantidadPersonas - $cantPersonal)+$i,
            'fecha_alta'=> $faker->date(),
            'manejo_de_grupo'=> $faker->randomElement(['excelente','bueno', 'regular', 'malo']),
            'legajo_personal'=>$faker->unique()->numberBetween(10000,19999),
          ]);
        }
    }
}
