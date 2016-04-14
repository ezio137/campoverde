<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensFavoritoResultadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_favorito_dre', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('favorito_dre_id');
            $table->string('conta_codigo_completo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('favorito_dre_id')->references('id')->on('favoritos_dre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('itens_favorito_dre');
    }
}
