<?php

use Illuminate\Database\Seeder;

class alumno_cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\alumno_curso::class, 10)->create();
    }
}
