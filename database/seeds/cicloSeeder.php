<?php

use Illuminate\Database\Seeder;

class cicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ciclo_lectivos')->insert([
      'anio' => '2020',
      'nombre' => 'Ciclo Lectivo 2020',
        ]);
    }
}
