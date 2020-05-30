<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class materiaSeeder extends Seeder
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

        DB::table('materias')->insert([
            'nombre' => 'Historia',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Primero'
        ]);

 		DB::table('materias')->insert([
            'nombre' => 'Matematica',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Segundo'

        ]);

         DB::table('materias')->insert([
            'nombre' => 'Geografia',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Tercero'

        ]);

         DB::table('materias')->insert([
            'nombre' => 'Literatura',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Cuarto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Biologia',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Quinto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Fisica',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Sexto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Educacion Fisica',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Primero'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'SIC',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Cuarto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'TEO',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Sexto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Arte',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Primero'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Ingles',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Segundo'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'SADO',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Tercero'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'NTICX',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Cuarto'
        ]);

         DB::table('materias')->insert([
            'nombre' => 'Derecho',
			'carga_horaria' => '4',
			'fecha_creacion' => '2005-05-20',
			'programa_materia' => 1,
			'estado_materia'=> 'activo',
			'horario_materia'=>	11,
			'curso_correspondiente' => 'Sexto'
        ]);
    }
}
