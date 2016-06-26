<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLancamentosFuturosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos_futuros', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->unsignedInteger('favorecido_id');
            $table->unsignedInteger('conta_a_pagar_id');
            $table->string('documento');
            $table->string('reconciliado')->nullable();
            $table->unsignedInteger('conta_credito_id');
            $table->unsignedInteger('conta_debito_id');
            $table->decimal('valor', 15);
            $table->unsignedInteger('parcela_atual');
            $table->unsignedInteger('parcela_total');
            $table->string('memorando')->nullable();
            $table->string('status_reconciliacao', 1)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('favorecido_id')->references('id')->on('favorecidos');
            $table->foreign('conta_a_pagar_id')->references('id')->on('contas_a_pagar');
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
        Schema::drop('lancamentos_futuros');
    }
}
