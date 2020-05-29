<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class personaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\persona::class, 50)->create();
    }
}
