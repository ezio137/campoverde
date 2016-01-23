<?php

use Illuminate\Database\Seeder;
use \App\Favorecido;

class FavorecidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Favorecido::create(['nome' => 'Édison']);
        Favorecido::create(['nome' => 'Consul']);
    }
}
