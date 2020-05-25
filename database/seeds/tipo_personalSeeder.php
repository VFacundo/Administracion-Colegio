<?php

use Illuminate\Database\Seeder;

class tipo_personalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_personals')->insert([
            'nombre_tipo' => 'Docente',
        ]);      

        DB::table('tipo_personals')->insert([
            'nombre_tipo' => 'Director',
        ]);      

        DB::table('tipo_personals')->insert([
            'nombre_tipo' => 'Preceptor',
        ]);      

        DB::table('tipo_personals')->insert([
            'nombre_tipo' => 'Secretaria',
        ]);      
 		

    }
}
