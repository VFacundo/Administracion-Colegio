<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class asistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('asistencias')->insert([
        'asistencia' => 'presente',
        'tipo' => 'completa'
       ]); 
    }
}
