<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class cursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\curso::class, 3)->create();
    }
}
