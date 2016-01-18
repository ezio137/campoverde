<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->unsignedInteger('favorecido_id');
            $table->string('documento');
            $table->unsignedInteger('conta_credito_id');
            $table->unsignedInteger('conta_debito_id');
            $table->decimal('valor');
            $table->string('memorando')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('favorecido_id')->references('id')->on('favorecidos');
            $table->foreign('conta_credito_id')->references('id')->on('contas');
            $table->foreign('conta_debito_id')->references('id')->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lancamentos');
    }
}
