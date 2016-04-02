<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Data;
use App\FavoritoBalancoPatrimonial;
use App\Http\Requests;
use App\Lancamento;
use App\SaldoConta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemonstracoesController extends Controller
{
    public function balancoPatrimonial(Request $request)
    {
        // Preparando a tabela de datas
        DB::table('datas')->delete();
        $resultDatas = DB::table('lancamentos')->select(DB::raw("date_format(last_day(data), '%Y-%m-%d') data"))->distinct()->pluck('data');
        $arrayDatas = array_map(function($data){
            return ['data' => $data];
        }, $resultDatas);
        Data::insert($arrayDatas);

        // Preparando a tabela de saldos
        DB::table('saldos_conta')->delete();
        $contas = Conta::all();
        $datas = Data::all();
        foreach ($datas as $data) {
            foreach ($contas as $conta) {
                $saldoCreditos = Lancamento::where('conta_credito_id', $conta->id)->where('data', '<=', $data->data)->sum('valor');
                $saldoDebitos = Lancamento::where('conta_debito_id', $conta->id)->where('data', '<=', $data->data)->sum('valor');
                $conta->aumentaComCredito
                    ? $saldo = $saldoCreditos - $saldoDebitos
                    : $saldo = $saldoDebitos - $saldoCreditos;
                SaldoConta::create(['conta_id' => $conta->id, 'data_id' => $data->id, 'saldo' => $saldo]);
            }
        }

        $contasOptions = Conta::contasOptions();
        $mesesOptions = Data::mesesOptions();

        $contasFavoritasOptions = collect([0 => 'Nenhum'])->all() + FavoritoBalancoPatrimonial::lists('nome', 'id')->all();
        $mesesFavoritosOptions = [];

        return view('demonstracoes.balanco_patrimonial', compact(
            'contasOptions',
            'mesesOptions',
            'contasFavoritasOptions',
            'mesesFavoritosOptions'
        ));
    }

    public function atualizarBalancoPatrimonial(Request $request)
    {
        if ($request->has('conta')) {
            $contaId = $request->input('conta');
            $request->session()->push('contas', $contaId);
        }
        if ($request->has('remove-conta')) {
            $contaId = $request->input('remove-conta');
            $request->session()->put('contas', array_diff($request->session()->get('contas'), [$contaId]));
        }
        if ($request->has('contas_favoritas')) {
            $codigos = FavoritoBalancoPatrimonial::find($request->input('contas_favoritas'))->itens()->lists('conta_codigo_completo');
            $contasIds = Conta::whereIn('codigo_completo', $codigos)->lists('id')->all();
            $request->session()->put('contas', $contasIds);
        }
        $contasIds = $request->session()->get('contas');

        if ($request->has('mes')) {
            $mesId = $request->input('mes');
            $request->session()->push('meses', $mesId);
        }
        if ($request->has('remove-mes')) {
            $mesId = $request->input('remove-mes');
            $request->session()->put('meses', array_diff($request->session()->get('meses'), [$mesId]));
        }
        $mesesIds = $request->session()->get('meses');

        $meses = Data::whereIn('id', $mesesIds)->orderBy('data')->get()->keyBy('id');

        $contasAtivo = $this->contas('1', $contasIds);
        $contasPassivo = $this->contas('2', $contasIds);
        $contasPL = $this->contas('3', $contasIds);

        $resultado = DB::table('contas as cc_filtro')
            ->select('cc_filtro.id as conta_id', 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('contas as cc', 'cc.codigo_completo', 'like', DB::raw("concat(cc_filtro.codigo_completo, '%')"))
            ->join('saldos_conta as scc', 'cc.id', '=', 'scc.conta_id')
            ->whereIn('cc_filtro.id', $contasIds)
            ->whereIn('scc.data_id', $mesesIds)
            ->whereNull('cc_filtro.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('scc.deleted_at')
            ->groupBy('cc_filtro.id', 'scc.data_id')
            ->get();
        $resultado = collect($resultado);

        $resultadoTotais = DB::table('contas as cc')
            ->select(DB::raw('substr(cc.codigo_completo, 1, 1) as tipo_conta'), 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('saldos_conta as scc', 'cc.id', '=', 'scc.conta_id')
            ->whereIn('scc.data_id', $mesesIds)
            ->whereNull('cc.deleted_at')
            ->whereNull('scc.deleted_at')
            ->groupBy(DB::raw('substr(cc.codigo_completo, 1, 1)'), 'scc.data_id')
            ->get();
        $resultadoTotais = collect($resultadoTotais);

        return view('demonstracoes.atualizar_balanco_patrimonial', compact(
            'meses',
            'contasAtivo',
            'contasPassivo',
            'contasPL',
            'resultado',
            'resultadoTotais'
        ));
    }

    private function contas($pattern, $contasIds)
    {
        return Conta::whereIn('id', $contasIds)
            ->orderBy('codigo_completo_ordenavel')
            ->where('codigo_completo', 'like', $pattern . '%')
            ->get()
            ->keyBy('id');
    }
}
