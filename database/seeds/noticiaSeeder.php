<?php

use Illuminate\Database\Seeder;

class noticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\noticia::class, 15)->create();
    }
}
