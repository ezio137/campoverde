<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LimpaTabelas::class);
        $this->call(ContasSeeder::class);
        $this->call(FavorecidosSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
