<?php namespace App\Services;

use App\Conta;
use App\Lancamento;
use App\ResultadoConta;
use App\SaldoConta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use \App\Data;

class ContasAPagarService
{
    public static function totais($contasIds, $dataInicial, $dataFinal)
    {
        $resultadoCreditosTotaisQuery = DB::table('lancamentos_futuros as lf');
        $resultadoDebitosTotaisQuery = DB::table('lancamentos_futuros as lf');

        if (!empty($contasIds)) {
            $resultadoCreditosTotaisQuery->whereIn('lf.conta_credito_id', $contasIds);
            $resultadoDebitosTotaisQuery->whereIn('lf.conta_debito_id', $contasIds);
        }

        if ($dataInicial) {
            $resultadoCreditosTotaisQuery->where('lf.data', '>=', $dataInicial);
            $resultadoDebitosTotaisQuery->where('lf.data', '>=', $dataInicial);
        }

        if ($dataFinal) {
            $resultadoCreditosTotaisQuery->where('lf.data', '<=', $dataFinal);
            $resultadoDebitosTotaisQuery->where('lf.data', '<=', $dataFinal);
        }

        $resultadoCreditosTotaisQuery->select(
            DB::raw('sum(lf.valor) as valor')
        );

        $resultadoDebitosTotaisQuery->select(
            DB::raw('sum(lf.valor) as valor')
        );

        $resultadoTotais = $resultadoDebitosTotaisQuery->first()->valor - $resultadoCreditosTotaisQuery->first()->valor;
        return $resultadoTotais;
    }
}
