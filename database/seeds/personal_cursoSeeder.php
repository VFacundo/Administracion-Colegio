<?php

use Illuminate\Database\Seeder;
use App\personal;
use App\curso;
use Faker\Factory as Faker;

class personal_cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //factory(App\personal_curso::class, 10)->create();
        $personal = personal::all();
        //$cursos = curso::all();

        for($i=1;$i<count($personal);$i++){
          DB::table('personal_cursos')->insert([
            'id_curso' => $faker->numberBetween(1,curso::count()),
            'id_personal' => $personal[$i]['id'],
          ]);
        }
    }
}
