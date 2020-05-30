<?php
use App\Model;
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
        factory(App\Persona::class, 80)->create();
    }
}
