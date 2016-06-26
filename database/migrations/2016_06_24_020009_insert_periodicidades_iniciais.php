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
        Periodicidade::create(['nome' => 'Diária', 'intervalo_quantidade' => 1, 'intervalo_unidade' => 'Day', 'ind_mesmo_dia' => false, 'ordem' => 1]);
        Periodicidade::create(['nome' => 'Semanal', 'intervalo_quantidade' => 7, 'intervalo_unidade' => 'Day', 'ind_mesmo_dia' => false, 'ordem' => 2]);
        Periodicidade::create(['nome' => 'Mensal', 'intervalo_quantidade' => 1, 'intervalo_unidade' => 'Month', 'ind_mesmo_dia' => true, 'ordem' => 3]);
        Periodicidade::create(['nome' => 'Bimestral', 'intervalo_quantidade' => 2, 'intervalo_unidade' => 'Month', 'ind_mesmo_dia' => true, 'ordem' => 4]);
        Periodicidade::create(['nome' => 'Trimestral', 'intervalo_quantidade' => 3, 'intervalo_unidade' => 'Month', 'ind_mesmo_dia' => true, 'ordem' => 5]);
        Periodicidade::create(['nome' => 'Semestral', 'intervalo_quantidade' => 6, 'intervalo_unidade' => 'Month', 'ind_mesmo_dia' => true, 'ordem' => 6]);
        Periodicidade::create(['nome' => 'Anual', 'intervalo_quantidade' => 12, 'intervalo_unidade' => 'Month', 'ind_mesmo_dia' => true, 'ordem' => 7]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contas_a_pagar')->update(['periodicidade_id' => null]);
        DB::table('periodicidades')->delete();
    }
}