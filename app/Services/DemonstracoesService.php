<?php namespace App\Services;

use App\Conta;
use App\Lancamento;
use App\ResultadoConta;
use App\SaldoConta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use \App\Data;

class DemonstracoesService
{
    public static function atualizarDatas()
    {
        $resultDatas = DB::table('lancamentos')->select(DB::raw("date_format(last_day(data), '%Y-%m-%d') data"))->distinct()->pluck('data');
        foreach ($resultDatas as $data) {
            if (!Data::where('data', $data)->exists()) {
                Data::create(['data' => $data]);
            }
        }
    }

    public static function atualizarSaldosMeses()
    {
        $horaCalculo = Carbon::now();
        $contas = Conta::all();
        $datas = Data::all();
        foreach ($datas as $data) {
            foreach ($contas as $conta) {
                $saldoCreditos = Lancamento::where('conta_credito_id', $conta->id)->where('data', '<=', $data->data)->sum('valor');
                $saldoDebitos = Lancamento::where('conta_debito_id', $conta->id)->where('data', '<=', $data->data)->sum('valor');
                $conta->aumentaComCredito
                    ? $saldo = $saldoCreditos - $saldoDebitos
                    : $saldo = $saldoDebitos - $saldoCreditos;
                SaldoConta::create(['hora_calculo' => $horaCalculo, 'conta_id' => $conta->id, 'data_id' => $data->id, 'saldo' => $saldo]);
            }
        }
        DB::table('saldos_conta')->where('hora_calculo', '<', $horaCalculo)->delete();
    }

    public static function atualizarResultadosMeses()
    {
        $horaCalculo = Carbon::now();
        $contas = Conta::all();
        $datas = Data::all();
        foreach ($datas as $data) {
            foreach ($contas as $conta) {
                $resultadoCreditos = Lancamento::where('conta_credito_id', $conta->id)
                    ->where(DB::raw("date_format(data, '%Y%m')"), '=', $data->data->format('Ym'))
                    ->sum('valor');
                $resultadoDebitos = Lancamento::where('conta_debito_id', $conta->id)
                    ->where(DB::raw("date_format(data, '%Y%m')"), '=', $data->data->format('Ym'))
                    ->sum('valor');
                $conta->aumentaComCredito
                    ? $resultado = $resultadoCreditos - $resultadoDebitos
                    : $resultado = $resultadoDebitos - $resultadoCreditos;
                ResultadoConta::create(['hora_calculo' => $horaCalculo, 'conta_id' => $conta->id, 'data_id' => $data->id, 'resultado' => $resultado]);
            }
        }
        DB::table('resultados_conta')->where('hora_calculo', '<', $horaCalculo)->delete();
    }

    public static function balancoPatrimonialContas($contasIds, $mesesIds, $horaCalculo)
    {
        $resultado = DB::table('contas as cc_filtro')
            ->select('cc_filtro.id as conta_id', 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('contas as cc', 'cc.codigo_completo', 'like', DB::raw("concat(cc_filtro.codigo_completo, '%')"))
            ->join('saldos_conta as scc', 'cc.id', '=', 'scc.conta_id')
            ->whereIn('cc_filtro.id', $contasIds)
            ->whereIn('scc.data_id', $mesesIds)
            ->whereNull('cc_filtro.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('scc.deleted_at')
            ->where('scc.hora_calculo', $horaCalculo)
            ->groupBy('cc_filtro.id', 'scc.data_id')
            ->get();
        $resultado = array_map(function($r){
            $r->conta_id = intval($r->conta_id);
            $r->data_id = intval($r->data_id);
            return $r;
        }, $resultado);
        return collect($resultado);
    }

    public static function balancoPatrimonialTotais($mesesIds, $horaCalculo)
    {
        $resultadoTotais = DB::table('contas as cc')
            ->select(DB::raw('substr(cc.codigo_completo, 1, 1) as tipo_conta'), 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('saldos_conta as scc', 'cc.id', '=', 'scc.conta_id')
            ->whereIn('scc.data_id', $mesesIds)
            ->whereNull('cc.deleted_at')
            ->whereNull('scc.deleted_at')
            ->where('scc.hora_calculo', $horaCalculo)
            ->groupBy(DB::raw('substr(cc.codigo_completo, 1, 1)'), 'scc.data_id')
            ->get();
        $resultadoTotais = array_map(function($r){
            $r->data_id = intval($r->data_id);
            return $r;
        }, $resultadoTotais);
        return collect($resultadoTotais);
    }

    public static function resultadoContas($contasIds, $mesesIds, $horaCalculo)
    {
        $resultado = DB::table('contas as cc_filtro')
            ->select('cc_filtro.id as conta_id', 'rcc.data_id', DB::raw('sum(rcc.resultado) as resultado'))
            ->join('contas as cc', 'cc.codigo_completo', 'like', DB::raw("concat(cc_filtro.codigo_completo, '%')"))
            ->join('resultados_conta as rcc', 'cc.id', '=', 'rcc.conta_id')
            ->whereIn('cc_filtro.id', $contasIds)
            ->whereIn('rcc.data_id', $mesesIds)
            ->whereNull('cc_filtro.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('rcc.deleted_at')
            ->where('rcc.hora_calculo', $horaCalculo)
            ->groupBy('cc_filtro.id', 'rcc.data_id')
            ->get();
        $resultado = array_map(function($r){
            $r->conta_id = intval($r->conta_id);
            $r->data_id = intval($r->data_id);
            return $r;
        }, $resultado);
        return collect($resultado);
    }

    public static function resultadoTotais($mesesIds, $horaCalculo)
    {
        $resultadoTotais = DB::table('contas as cc')
            ->select(DB::raw('substr(cc.codigo_completo, 1, 1) as tipo_conta'), 'rcc.data_id', DB::raw('sum(rcc.resultado) as resultado'))
            ->join('resultados_conta as rcc', 'cc.id', '=', 'rcc.conta_id')
            ->whereIn('rcc.data_id', $mesesIds)
            ->whereNull('cc.deleted_at')
            ->whereNull('rcc.deleted_at')
            ->where('rcc.hora_calculo', $horaCalculo)
            ->groupBy(DB::raw('substr(cc.codigo_completo, 1, 1)'), 'rcc.data_id')
            ->get();
        $resultadoTotais = array_map(function($r){
            $r->data_id = intval($r->data_id);
            return $r;
        }, $resultadoTotais);
        return collect($resultadoTotais);
    }
}
