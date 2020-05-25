<?php

use Illuminate\Database\Seeder;

class tipo_notaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('tipo_notas')->insert([
            'nombre_tipo' => 'Concepto'       
        ]);

        DB::table('tipo_notas')->insert([
            'nombre_tipo' => 'Evaluacion'       
        ]);

        DB::table('tipo_notas')->insert([
            'nombre_tipo' => 'TP'       
        ]);
    }
}
