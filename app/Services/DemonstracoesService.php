<?php namespace App\Services;

use App\Conta;
use App\Lancamento;
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
}
