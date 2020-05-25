<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class preguntasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\pregunta::class, 10)->create();
    }
}
