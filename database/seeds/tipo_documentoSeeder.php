<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipo_documentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipo_documentos')->insert([
            'nombre_tipo' => 'DNI',
			'descripcion' => 'Documento Nacional de Identidad'	           
        ]);   

        DB::table('tipo_documentos')->insert([
            'nombre_tipo' => 'DU',
			'descripcion' => 'Documento Unico'	           
        ]);
    }
}
