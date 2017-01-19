<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Data;
use App\FavoritoBalancoPatrimonial;
use App\FavoritoResultado;
use App\Http\Requests;
use App\Jobs\AtualizarResultadosMesesJob;
use App\Jobs\AtualizarSaldosMesesJob;
use App\ResultadoConta;
use App\SaldoConta;
use App\Services\DemonstracoesService;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;

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

        $contasFavoritasOptions = FavoritoBalancoPatrimonial::pluck('nome', 'id')->all();
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

    /**
     * @param Request $request
     * @return mixed
     */
    public function atualizarDadosSession(Request $request)
    {
        session()->has('contas') ? null : session()->put('contas', collect());
        if ($request->has('conta')) {
            $contaId = $request->input('conta');
            session()->get('contas')->push($contaId);
        }
        if ($request->has('remove-conta')) {
            $contaId = $request->input('remove-conta');
            session()->put('contas', session()->get('contas')->reject(function ($value) use ($contaId) {
                return $value == $contaId;
            }));
        }
        if ($request->has('expande-conta')) {
            $contaId = $request->input('expande-conta');
            foreach (Conta::find($contaId)->contasFilhas as $conta) {
                session()->get('contas')->push($conta->id);
            }
        }
        if ($request->has('contas_favoritas')) {
            $codigos = FavoritoBalancoPatrimonial::find($request->input('contas_favoritas'))->itens()->pluck('conta_codigo_completo');
            $contasIds = Conta::whereIn('codigo_completo', $codigos)->pluck('id');
            session()->put('contas', $contasIds);
            return $contasIds;
        }

        session()->has('meses') ? null : session()->put('meses', collect());
        if ($request->has('mes')) {
            $mesId = $request->input('mes');
            session()->get('meses')->push($mesId);
        }
        if ($request->has('remove-mes')) {
            $mesId = $request->input('remove-mes');
            session()->put('meses', session()->get('meses')->reject(function ($value) use ($mesId) {
                return $value == $mesId;
            }));
        }


        session()->has('contas_resultado') ? null : session()->put('contas_resultado', collect());
        if ($request->has('conta_resultado')) {
            $contaId = $request->input('conta_resultado');
            if (!session()->get('contas_resultado')->has($contaId)) {
                session()->get('contas_resultado')->push($contaId);
            }
        }
        if ($request->has('contas_favoritas_resultado')) {
            $codigos = FavoritoResultado::find($request->input('contas_favoritas_resultado'))->itens()->pluck('conta_codigo_completo');
            $contasIds = Conta::whereIn('codigo_completo', $codigos)->pluck('id');
            session()->put('contas_resultado', $contasIds);
            return $contasIds;
        }
        if ($request->has('remove-conta-resultado')) {
            $contaId = $request->input('remove-conta-resultado');
            session()->put('contas_resultado', session()->get('contas_resultado')->reject(function ($value) use ($contaId) {
                return $value == $contaId;
            }));
        }
        session()->has('periodos') ? null : session()->put('periodos', collect());
        if ($request->has('mes_inicio') && $request->has('mes_fim')) {
            $mesInicioId = $request->input('mes_inicio');
            $mesFimId = $request->input('mes_fim');
            if (session()->get('periodos')->search(['inicio' => $mesInicioId, 'fim' => $mesFimId]) === false) {
                session()->get('periodos')->push(['inicio' => $mesInicioId, 'fim' => $mesFimId]);
            }
        }
        if ($request->has('remove-periodo')) {
            $periodoId = $request->input('remove-periodo');
            session()->put('periodos', collect(session()->get('periodos'))->reject(function ($value) use ($periodoId) {
                list($mesInicioId, $mesFimId) = explode('_', $periodoId);
                return $value['inicio'] == $mesInicioId && $value['fim'] == $mesFimId;
            }));
        }
    }

    private function contas($pattern, $contasIds)
    {
        return Conta::whereIn('id', $contasIds)
            ->orderBy('codigo_completo_ordenavel')
            ->where('codigo_completo', 'like', $pattern . '%')
            ->get()
            ->keyBy('id');
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

    public function resultado()
    {
        // Preparando a tabela de datas
        DemonstracoesService::atualizarDatas();

        // Preparando a tabela de saldos
        $this->dispatch(new AtualizarResultadosMesesJob());

        $contasOptions = Conta::contasOptions(0, [4, 5]);
        $mesesOptions = Data::mesesOptionsSelecione();

        $contasFavoritasOptions = FavoritoResultado::pluck('nome', 'id')->all();
        $mesesFavoritosOptions = [];

        return view('demonstracoes.resultado.index', compact(
            'contasOptions',
            'mesesOptions',
            'contasFavoritasOptions',
            'mesesFavoritosOptions'
        ));
    }

    public function dadosResultado(Request $request)
    {
        $horaCalculo = ResultadoConta::min('hora_calculo');

        $this->atualizarDadosSession($request);

        $contasIds = session()->get('contas_resultado');
        $periodosIds = session()->get('periodos', collect());

        $periodos = [];
        foreach ($periodosIds as $periodoId) {
            $periodos[] = [
                'id' => $periodoId['inicio'].'_'.$periodoId['fim'],
                'inicio' => Data::find($periodoId['inicio']),
                'fim' => Data::find($periodoId['fim'])
            ];
        }

        $contasReceita = $this->contas('4', $contasIds);
        $contasDespesa = $this->contas('5', $contasIds);

        $resultado = DemonstracoesService::resultadoContas($contasIds, $periodosIds, $horaCalculo);
        $resultadoTotais = DemonstracoesService::resultadoTotais($periodosIds, $horaCalculo);

        $media = 'screen';
        return view('demonstracoes.resultado.partials.dados', compact(
            'periodos',
            'contasReceita',
            'contasDespesa',
            'resultado',
            'resultadoTotais',
            'media'
        ));
    }

    public function relatorioResultado(Request $request)
    {
        $horaCalculo = ResultadoConta::min('hora_calculo');

        $contasIds = session()->get('contas_resultado');
        $periodosIds = session()->get('periodos', collect());

        $periodos = [];
        foreach ($periodosIds as $periodoId) {
            $periodos[] = [
                'id' => $periodoId['inicio'] . '_' . $periodoId['fim'],
                'inicio' => Data::find($periodoId['inicio']),
                'fim' => Data::find($periodoId['fim'])
            ];
        }

        $contasReceita = $this->contas('4', $contasIds);
        $contasDespesa = $this->contas('5', $contasIds);

        $resultado = DemonstracoesService::resultadoContas($contasIds, $periodosIds, $horaCalculo);
        $resultadoTotais = DemonstracoesService::resultadoTotais($periodosIds, $horaCalculo);

        $media = 'print';
        $pdf = PDF::loadView('demonstracoes.resultado.relatorio', compact(
            'periodos',
            'contasReceita',
            'contasDespesa',
            'resultado',
            'resultadoTotais',
            'media'
        ));
        return $pdf->setOrientation('landscape')->inline('resultado.pdf');
    }
}
