<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lancamento_id');
            $table->string('nome');
            $table->string('extensao');
            $table->string('nome_original');
            $table->integer('tamanho_bytes');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lancamento_id')->references('id')->on('lancamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('anexos');
    }
}
