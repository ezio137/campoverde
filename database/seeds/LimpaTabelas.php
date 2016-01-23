<?php

use Illuminate\Database\Seeder;

class LimpaTabelas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contas')->delete();
        DB::table('favorecidos')->delete();
    }
}
