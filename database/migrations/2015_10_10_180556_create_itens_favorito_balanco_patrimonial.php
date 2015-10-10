<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItensFavoritoBalancoPatrimonial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_favorito_bp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('favorito_bp_id');
            $table->string('conta_codigo_completo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('favorito_bp_id')->references('id')->on('favoritos_bp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('itens_favorito_bp');
    }
}
