<?php

use Illuminate\Database\Seeder;

class personal_cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\personal_curso::class, 10)->create();
    }
}
