<?php

use Illuminate\Database\Seeder;

class horario_materiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\horario_materia::class, 15)->create();
    }
}
