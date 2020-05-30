<?php

use Illuminate\Database\Seeder;
use App\alumno;
use App\curso;
use Faker\Factory as Faker;

class alumno_cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      $cursos = curso::all();
      $alumnos = alumno::all();

      for($i=0;$i<count($alumnos);$i++){
          DB::table('alumno_cursos')->insert([
            'id_alumno' => $alumnos[$i]['id'],
            'id_curso' => $faker->numberBetween(1,count($cursos)),
          ]);
      }
    }
}
