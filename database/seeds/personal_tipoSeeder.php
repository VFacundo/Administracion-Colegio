<?php

use Illuminate\Database\Seeder;

class personal_tipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\personal_tipo::class, 9)->create();
    }
}
