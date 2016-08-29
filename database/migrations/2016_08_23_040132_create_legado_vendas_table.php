<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLegadoVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legado_vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cliente');
            $table->date('data_venda');
            $table->string('produto');
            $table->decimal('quantidade');
            $table->unsignedInteger('codigo_tipo')->nullable();
            $table->decimal('preco')->nullable();
            $table->decimal('total');
            $table->string('periodo')->nullable();
            $table->boolean('ind_quitado')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('legado_vendas');
    }
}
