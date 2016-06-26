<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContasAPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_a_pagar', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_proxima');
            $table->unsignedInteger('favorecido_id');
            $table->string('documento');
            $table->unsignedInteger('conta_credito_id');
            $table->unsignedInteger('conta_debito_id');
            $table->decimal('valor', 15);
            $table->string('memorando')->nullable();
            $table->unsignedInteger('parcela_atual')->nullable();
            $table->unsignedInteger('parcela_total')->nullable();
            $table->unsignedInteger('periodicidade_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('favorecido_id')->references('id')->on('favorecidos');
            $table->foreign('periodicidade_id')->references('id')->on('periodicidades');
            $table->foreign('conta_credito_id')->references('id')->on('contas');
            $table->foreign('conta_debito_id')->references('id')->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contas_a_pagar');
    }
}
