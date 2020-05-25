<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class programa_materiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('programa_materias')->insert([
            'nombre_archivo' => 'Prueba2',
			'localizacion_archivo' => '/doc/programas/' ,
			'fecha_subida' => '2005-05-20',	
			'vigente_desde' => '2006-05-20',
			'vigente_hasta' => '2009-05-20'           
        ]);  
    }
}
