<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosContaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_conta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('conta_id');
            $table->unsignedInteger('data_id');
            $table->decimal('resultado', 15);
            $table->timestamp('hora_calculo');
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
        Schema::drop('resultados_conta');
    }
}
