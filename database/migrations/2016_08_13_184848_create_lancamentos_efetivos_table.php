<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLancamentosEfetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos_efetivos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lancamento_id');
            $table->date('data');
            $table->unsignedInteger('conta_id');
            $table->decimal('valor', 15);
            $table->timestamps();

            $table->foreign('lancamento_id')->references('id')->on('lancamentos');
            $table->foreign('conta_id')->references('id')->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lancamentos_efetivos');
    }
}
