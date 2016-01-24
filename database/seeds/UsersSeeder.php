<?php

use \App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['username' => 'admin', 'name' => 'Administrador', 'email' => 'admin@fagan.com.br', 'password' => bcrypt('admin')]);
    }
}
