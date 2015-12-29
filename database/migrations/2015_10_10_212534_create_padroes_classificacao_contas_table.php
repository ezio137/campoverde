<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePadroesClassificacaoContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padroes_classificacao_contas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_classificacao_contas_id');
            $table->string('padrao');
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
        Schema::drop('padroes_classificacao_contas');
    }
}
