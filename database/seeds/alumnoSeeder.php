<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class alumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\alumno::class, 100)->create();
    }
}
