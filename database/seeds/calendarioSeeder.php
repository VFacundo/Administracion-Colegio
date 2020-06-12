<?php

use Illuminate\Database\Seeder;

class calendarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('calendarios')->insert([
	        'fecha' => '2020-05-26',
	        'anio' => 2020,
	        'mes_numero' => 05,
	        'dia_numero' => 26,
	        'mes_nombre' => 'mayo',
	        'asistencia' => 1,
          'id_alumno' => 1,
		]);

    }
}
