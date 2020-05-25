<?php

use Illuminate\Database\Seeder;

class personal_materiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\personal_materia::class, 8)->create();
    }
}
