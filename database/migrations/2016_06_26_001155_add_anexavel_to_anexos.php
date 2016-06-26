<?php

use App\Anexo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAnexavelToAnexos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anexos', function (Blueprint $table) {
            $table->unsignedInteger('anexavel_id');
            $table->string('anexavel_type');
        });

        $anexos = Anexo::all();
        foreach ($anexos as $anexo) {
            $anexo->anexavel_type = 'Lancamento';
            $anexo->anexavel_id = $anexo->lancamento_id;
            $anexo->save();
        }

        Schema::table('anexos', function (Blueprint $table) {
            $table->dropForeign('anexos_lancamento_id_foreign');
            $table->dropColumn('lancamento_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anexos', function (Blueprint $table) {
            $table->unsignedInteger('lancamento_id');
            $table->foreign('lancamento_id')->references('id')->on('lancamentos');
        });

        $anexos = Anexo::all();
        foreach ($anexos as $anexo) {
            $anexo->lancamento_id = $anexo->anexavel_id;
            $anexo->save();
        }

        Schema::table('anexos', function (Blueprint $table) {
            $table->dropColumn('anexavel_id');
            $table->dropColumn('anexavel_type');
        });
    }
}
