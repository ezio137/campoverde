<?php

use App\Periodicidade;
use Illuminate\Database\Migrations\Migration;

class InsertPeriodicidadesIniciais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Periodicidade::create(['nome' => 'Diária', 'numero_dias' => 1, 'ind_mesmo_dia' => false]);
        Periodicidade::create(['nome' => 'Semanal', 'numero_dias' => 7, 'ind_mesmo_dia' => false]);
        Periodicidade::create(['nome' => 'Mensal', 'numero_dias' => 30, 'ind_mesmo_dia' => true]);
        Periodicidade::create(['nome' => 'Bimestral', 'numero_dias' => 60, 'ind_mesmo_dia' => true]);
        Periodicidade::create(['nome' => 'Trimestral', 'numero_dias' => 90, 'ind_mesmo_dia' => true]);
        Periodicidade::create(['nome' => 'Semestral', 'numero_dias' => 180, 'ind_mesmo_dia' => true]);
        Periodicidade::create(['nome' => 'Anual', 'numero_dias' => 365, 'ind_mesmo_dia' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('periodicidades')->delete();
    }
}
