<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(tipo_documentoSeeder::class);
        $this->call(tipo_personalSeeder::class);
        $this->call(tipo_notaSeeder::class);
        $this->call(programa_materiaSeeder::class);
        $this->call(asistenciaSeeder::class);
        $this->call(calendarioSeeder::class);
        $this->call(personaSeeder::class);
        $this->call(userSeeder::class);
        $this->call(materiaSeeder::class);
        $this->call(preguntasSeeder::class);
        $this->call(cursoSeeder::class);
        $this->call(alumnoSeeder::class);
        $this->call(alumno_cursoSeeder::class);
        $this->call(nota_alumnoSeeder::class);
        $this->call(nota_alumno_finalSeeder::class);
        $this->call(horario_materiaSeeder::class);
        $this->call(materia_cursoSeeder::class);
        $this->call(noticiaSeeder::class);
        $this->call(notificacionSeeder::class);
        $this->call(personalSeeder::class);
        $this->call(personal_tipoSeeder::class);
        $this->call(personal_materiaSeeder::class);
        $this->call(personal_cursoSeeder::class);
        $this->call(encuestaSeeder::class);






    }
}
