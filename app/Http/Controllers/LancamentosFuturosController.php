<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Favorecido;
use App\Http\Requests;
use App\Lancamento;
use App\LancamentoFuturo;
use App\Services\ContasAPagarService;
use App\Services\DateHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LancamentosFuturosController extends Controller
{
    public function index()
    {
        $lancamentos = LancamentoFuturo::orderBy('data')->get();

        return view('lancamentos_futuros.index', compact('lancamentos'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Próximas Contas a Pagar');
    }

    public function preparar(LancamentoFuturo $lancamentoFuturo)
    {
        $favorecidosOptions = Favorecido::favorecidosOptions();
        $contasOptions = Conta::contasOptions();

        return view('lancamentos_futuros.preparar', compact('lancamentoFuturo', 'favorecidosOptions', 'contasOptions'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Registrar Conta a Pagar');
    }

    public function registrar(LancamentoFuturo $lancamentoFuturo)
    {
        // Inserir Lancamento
        Lancamento::create(array_except($lancamentoFuturo->toArray(), ['id']));

        // Atualizar Conta a Pagar
        $lancamentoFuturo->contaAPagar->increment('parcela_atual');

        // Excluir Lancamento Futuro
        $lancamentoFuturo->delete();

        return redirect()->route('lancamentos_futuros.index');
    }

    public function getRelatorio(Request $request)
    {
        $contasOptions = Conta::contasOptions(0, [1, 2, 3]);
        $contasSelecionadas = collect($request->session()->get('contas_relatorio_lancamentos_futuros'));
        $dataInicialFormatada = DateHelper::exibirData(session()->get('dataInicial'));
        $dataFinalFormatada = DateHelper::exibirData(session()->get('dataFinal'));

        return view('contas_a_pagar.relatorio.index', compact(
            'contasOptions', 'contasSelecionadas', 'dataInicialFormatada', 'dataFinalFormatada'
        ))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Contas a Pagar');
    }

    public function dadosRelatorio(Request $request)
    {
        $this->atualizarDadosSession($request);

        $contasIds = $request->session()->get('contas_relatorio_lancamentos_futuros');
        $dataInicial = $request->session()->get('dataInicial');
        $dataFinal = $request->session()->get('dataFinal');
        $groupBy = $request->session()->get('groupBy');

        $resultadoTotais = ContasAPagarService::totais($contasIds, $dataInicial, $dataFinal, $groupBy);

        $media = 'screen';
        $dataInicialFormatada = DateHelper::exibirData($dataInicial);
        $dataFinalFormatada = DateHelper::exibirData($dataFinal);
        return view('contas_a_pagar.relatorio.partials.dados', compact(
            'resultadoTotais',
            'dataInicialFormatada',
            'dataFinalFormatada',
            'media'
        ));
    }

    public function atualizarDadosSession(Request $request)
    {
        if (!$request->session()->has('contas_relatorio_lancamentos_futuros')) {
            session()->put('contas_relatorio_lancamentos_futuros', collect());
        }
        if ($request->has('contas_relatorio_lancamentos_futuros')) {
            session()->put('contas_relatorio_lancamentos_futuros', $request->input('contas_relatorio_lancamentos_futuros'));
        }

        session()->has('dataInicial') ? null : session()->put('dataInicial', Carbon::create(1900, 1, 1));
        if ($request->has('dataInicialFormatada')) {
            session()->put('dataInicial', DateHelper::extrairData($request->input('dataInicialFormatada')));
        }

        session()->has('dataFinal') ? null : session()->put('dataFinal', Carbon::create(2100, 12, 31));
        if ($request->has('dataFinalFormatada')) {
            session()->put('dataFinal', DateHelper::extrairData($request->input('dataFinalFormatada')));
        }
    }
}
