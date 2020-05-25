<?php

use Illuminate\Database\Seeder;

class notificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\notificacion::class, 30)->create();
    }
}
