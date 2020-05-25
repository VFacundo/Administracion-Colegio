<?php

use Illuminate\Database\Seeder;

class nota_alumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(App\nota_alumno::class,3)->create();
    }
}
