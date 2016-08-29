<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItensVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_venda', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('venda_id');
            $table->unsignedInteger('variedade_fruta_id');
            $table->unsignedInteger('tipo_embalagem_id');
            $table->decimal('quantidade');
            $table->decimal('preco');
            $table->timestamps();

            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->foreign('variedade_fruta_id')->references('id')->on('variedades_fruta');
            $table->foreign('tipo_embalagem_id')->references('id')->on('tipos_embalagem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('itens_venda');
    }
}
