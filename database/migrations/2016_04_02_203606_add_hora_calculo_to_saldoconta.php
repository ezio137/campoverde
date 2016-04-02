<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoraCalculoToSaldoconta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('saldos_conta')->delete();
        Schema::table('saldos_conta', function(Blueprint $table){
            $table->timestamp('hora_calculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saldos_conta', function(Blueprint $table){
            $table->dropColumn('hora_calculo');
        });
    }
}
