<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSaldosContaContabilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_conta_contabil', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('conta_contabil_id');
            $table->unsignedInteger('data_id');
            $table->decimal('saldo', 15);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('saldos_conta_contabil');
    }
}