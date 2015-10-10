<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Data;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemonstracoesController extends Controller
{
    public function balancoPatrimonial(Request $request)
    {
        $contasOptions = Conta::contasOptions();
        $mesesOptions = Data::mesesOptions();

        $contasFavoritasOptions = [];
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

        $resultado = DB::table('contas_contabil as cc_filtro')
            ->select('cc_filtro.id as conta_id', 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('contas_contabil as cc', 'cc.codigo_completo', 'like', DB::raw("concat(cc_filtro.codigo_completo, '%')"))
            ->join('saldos_conta_contabil as scc', 'cc.id', '=', 'scc.conta_contabil_id')
            ->whereIn('cc_filtro.id', $contasIds)
            ->whereIn('scc.data_id', $mesesIds)
            ->groupBy('cc_filtro.id', 'scc.data_id')
            ->get();
        $resultado = collect($resultado);

        $resultadoTotais = DB::table('contas_contabil as cc')
            ->select(DB::raw('substr(cc.codigo_completo, 1, 1) as tipo_conta'), 'scc.data_id', DB::raw('sum(scc.saldo) as saldo'))
            ->join('saldos_conta_contabil as scc', 'cc.id', '=', 'scc.conta_contabil_id')
            ->whereIn('scc.data_id', $mesesIds)
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
