<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLegadoTiposEmbalagemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legado_tipos_embalagem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->decimal('peso');
            $table->string('embalagem')->nullable();
            $table->string('tipo_fruta')->nullable();
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
        Schema::drop('legado_tipos_embalagem');
    }
}
