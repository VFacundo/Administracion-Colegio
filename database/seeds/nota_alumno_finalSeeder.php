<?php

use Illuminate\Database\Seeder;

class nota_alumno_finalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\nota_alumno_final::class, 5)->create();
    }
}
