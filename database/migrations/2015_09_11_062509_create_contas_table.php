<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('codigo');
            $table->string('codigo_completo');
            $table->string('codigo_completo_ordenavel');
            $table->unsignedInteger('conta_pai_id')->nullable();
            $table->decimal('saldo')->default(0.0);
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('conta_pai_id')->references('id')->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contas');
    }
}
