<?php

use Illuminate\Database\Seeder;

class personalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\personal::class, 31)->create();
    }
}
