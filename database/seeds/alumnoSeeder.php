<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Persona;
use Faker\Factory as Faker;

class alumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\alumno::class, 40)->create();
        $faker = Faker::create();
        $personas = Persona::all();
        $cantidadPersonas = count($personas);
        $cantAlumnos = ((80*$cantidadPersonas)/100)/2;

        for($i=1;$i<$cantAlumnos;$i++){
          DB::table('alumnos')->insert([
            'legajo_alumno'=>$faker->unique()->numberBetween(1,9999),
            'persona_asociada' => $personas[$i]['id'],
            'id_calendario' => 1,
            'persona_tutor' => $personas[$i+$cantAlumnos]['id']
          ]);
        }
    }
}
