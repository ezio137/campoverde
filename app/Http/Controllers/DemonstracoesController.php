<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Data;
use App\FavoritoBalancoPatrimonial;
use App\Http\Requests;
use App\Jobs\AtualizarSaldosMesesJob;
use App\Lancamento;
use App\SaldoConta;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DemonstracoesService;

class DemonstracoesController extends Controller
{
    public function balancoPatrimonial()
    {
        // Preparando a tabela de datas
        DemonstracoesService::atualizarDatas();

        // Preparando a tabela de saldos
        $this->dispatch(new AtualizarSaldosMesesJob());

        $contasOptions = Conta::contasOptions(0, [1, 2, 3]);
        $mesesOptions = Data::mesesOptionsSelecione();

        $contasFavoritasOptions = collect([0 => 'Nenhum'])->all() + FavoritoBalancoPatrimonial::lists('nome', 'id')->all();
        $mesesFavoritosOptions = [];

        return view('demonstracoes.balanco_patrimonial.index', compact(
            'contasOptions',
            'mesesOptions',
            'contasFavoritasOptions',
            'mesesFavoritosOptions'
        ));
    }

    public function dadosBalancoPatrimonial(Request $request)
    {
        $horaCalculo = SaldoConta::min('hora_calculo');

        $this->atualizarDadosSession($request);

        $contasIds = $request->session()->get('contas');
        $mesesIds = $request->session()->get('meses');

        $meses = Data::whereIn('id', $mesesIds)->orderBy('data')->get()->keyBy('id');

        $contasAtivo = $this->contas('1', $contasIds);
        $contasPassivo = $this->contas('2', $contasIds);
        $contasPL = $this->contas('3', $contasIds);

        $resultado = DemonstracoesService::balancoPatrimonialContas($contasIds, $mesesIds, $horaCalculo);
        $resultadoTotais = DemonstracoesService::balancoPatrimonialTotais($mesesIds, $horaCalculo);

        $media = 'screen';
        return view('demonstracoes.balanco_patrimonial.partials.dados', compact(
            'meses',
            'contasAtivo',
            'contasPassivo',
            'contasPL',
            'resultado',
            'resultadoTotais',
            'media'
        ));
    }

    public function relatorioBalancoPatrimonial(Request $request)
    {
        $horaCalculo = SaldoConta::min('hora_calculo');

        $contasIds = $request->session()->get('contas');
        $mesesIds = $request->session()->get('meses');

        $meses = Data::whereIn('id', $mesesIds)->orderBy('data')->get()->keyBy('id');

        $contasAtivo = $this->contas('1', $contasIds);
        $contasPassivo = $this->contas('2', $contasIds);
        $contasPL = $this->contas('3', $contasIds);

        $resultado = DemonstracoesService::balancoPatrimonialContas($contasIds, $mesesIds, $horaCalculo);
        $resultadoTotais = DemonstracoesService::balancoPatrimonialTotais($mesesIds, $horaCalculo);

        $media = 'print';
        $pdf = PDF::loadView('demonstracoes.balanco_patrimonial.relatorio', compact(
            'meses',
            'contasAtivo',
            'contasPassivo',
            'contasPL',
            'resultado',
            'resultadoTotais',
            'media'
        ));
        return $pdf->setOrientation('landscape')->inline('balanco_patrimonial.pdf');
    }

    private function contas($pattern, $contasIds)
    {
        return Conta::whereIn('id', $contasIds)
            ->orderBy('codigo_completo_ordenavel')
            ->where('codigo_completo', 'like', $pattern . '%')
            ->get()
            ->keyBy('id');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function atualizarDadosSession(Request $request)
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
            return $contasIds;
        }


        if ($request->has('mes')) {
            $mesId = $request->input('mes');
            $request->session()->push('meses', $mesId);
        }
        if ($request->has('remove-mes')) {
            $mesId = $request->input('remove-mes');
            $request->session()->put('meses', array_diff($request->session()->get('meses'), [$mesId]));
        }
    }
}
