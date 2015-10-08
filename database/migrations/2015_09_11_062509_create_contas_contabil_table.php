<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContasContabilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_contabil', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('codigo');
            $table->string('codigo_completo');
            $table->unsignedInteger('conta_pai_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('conta_pai_id')->references('id')->on('contas_contabil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contas_contabil');
    }
}
