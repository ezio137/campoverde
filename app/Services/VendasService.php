<?php namespace App\Services;

use App\Conta;
use App\Lancamento;
use App\ResultadoConta;
use App\SaldoConta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use \App\Data;

class VendasService
{
    public static function totais($frutasIds, $dataInicial, $dataFinal)
    {
        $resultadoTotaisQuery = DB::table('itens_venda as iv')
            ->join('vendas as v', 'v.id', '=', 'iv.venda_id')
            ->join('tipos_embalagem as te', 'te.id', '=', 'iv.tipo_embalagem_id')
            ->join('variedades_fruta as vf', 'vf.id', '=', 'iv.variedade_fruta_id');

        if (!empty($frutasIds)) {
            $resultadoTotaisQuery->whereIn('vf.fruta_id', $frutasIds);
        }

        if ($dataInicial) {
            $resultadoTotaisQuery->where('v.data_venda', '>=', $dataInicial);
        }

        if ($dataFinal) {
            $resultadoTotaisQuery->where('v.data_venda', '<=', $dataFinal);
        }

        $resultadoTotaisQuery->select(
            DB::raw('sum(iv.quantidade) as quantidade'),
            DB::raw('sum(te.peso * iv.quantidade) as peso'),
            DB::raw('sum(iv.preco * iv.quantidade) as preco')
        );

        $resultadoTotais = $resultadoTotaisQuery->get();
        return $resultadoTotais;
    }

    public static function subTotais($frutasIds, $dataInicial, $dataFinal, $groupBy)
    {
        $resultadoTotaisQuery = DB::table('itens_venda as iv')
            ->join('vendas as v', 'v.id', '=', 'iv.venda_id')
            ->join('tipos_embalagem as te', 'te.id', '=', 'iv.tipo_embalagem_id')
            ->join('classificacoes_fruta as cf', 'cf.id', '=', 'te.classificacao_fruta_id')
            ->join('variedades_fruta as vf', 'vf.id', '=', 'iv.variedade_fruta_id')
            ->join('clientes as c', 'c.id', '=', 'v.cliente_id');

        if (!empty($frutasIds)) {
            $resultadoTotaisQuery->whereIn('vf.fruta_id', $frutasIds);
        }

        if ($dataInicial) {
            $resultadoTotaisQuery->where('v.data_venda', '>=', $dataInicial);
        }

        if ($dataFinal) {
            $resultadoTotaisQuery->where('v.data_venda', '<=', $dataFinal);
        }

        $campoSelect = DB::raw('c.nome as groupBy');
        $campoGroupBy = DB::raw('c.nome');
        switch ($groupBy) {
            case 'cliente':
                $campoSelect = DB::raw('c.nome as groupBy');
                $campoGroupBy = DB::raw('c.nome');
                break;
            case 'tipoFruta':
                $campoSelect = DB::raw('cf.nome as groupBy');
                $campoGroupBy = DB::raw('cf.nome');
                break;
        }
        $resultadoTotaisQuery->select(
            $campoSelect,
            DB::raw('sum(iv.quantidade) as quantidade'),
            DB::raw('sum(te.peso * iv.quantidade) as peso'),
            DB::raw('sum(iv.preco * iv.quantidade) as preco')
        );

        $resultadoTotaisQuery->groupBy($campoGroupBy);

        $resultadoTotais = $resultadoTotaisQuery->get();
        return $resultadoTotais;
    }
}
