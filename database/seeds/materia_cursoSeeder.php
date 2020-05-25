<?php

use Illuminate\Database\Seeder;

class materia_cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\materia_curso::class, 15)->create();
    }
}
