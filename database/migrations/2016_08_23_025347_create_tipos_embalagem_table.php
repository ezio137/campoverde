<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposEmbalagemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_embalagem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->decimal('peso');
            $table->unsignedInteger('material_embalagem_id')->nullable();
            $table->unsignedInteger('classificacao_fruta_id')->nullable();
            $table->unsignedInteger('codigo_legado')->nullable();
            $table->timestamps();

            $table->foreign('material_embalagem_id')->references('id')->on('materiais_embalagem');
            $table->foreign('classificacao_fruta_id')->references('id')->on('classificacoes_fruta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipos_embalagem');
    }
}
