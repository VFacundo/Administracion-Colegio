<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Persona;
use Faker\Factory as Faker;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class, 50)->create();
        $faker = Faker::create();
        $personas = Persona::all();

        for($i=1;$i<count($personas);$i++){

          DB::table('users')->insert([
          'name' => $personas[$i]['dni_persona'],
          'email' => $personas[$i]['nombre_persona'] . $personas[$i]['apellido_persona'] . $personas[$i]['dni_persona'] . '@gmail.com',
          'email_verified_at' => now(),
          'password' => $personas[$i]['dni_persona'],
          'id_persona'=> $personas[$i]['id'],
          'estado_usuario'=> $faker->randomElement(['activo','inactivo']),
          'remember_token' => Str::random(10),
          ]);

        }

    }
}
