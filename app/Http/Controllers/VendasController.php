<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Fruta;
use App\Http\Requests;
use App\ItemVenda;
use App\Services\DateHelper;
use App\Services\VendasService;
use App\TipoEmbalagem;
use App\VariedadeFruta;
use App\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VendasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::orderBy('data_venda', 'desc')->paginate(20);

        return view('vendas.index', compact('vendas'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Vendas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venda = new Venda();
        $clientesOptions = Cliente::options();
        $variedadesOptions = VariedadeFruta::options();
        $embalagensOptions = TipoEmbalagem::options();

        return view('vendas.create', compact('venda', 'clientesOptions', 'variedadesOptions', 'embalagensOptions'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Vendas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Venda::$rules);

        $venda = Venda::create($request->all());

        $itens = collect($request->input('itens', []));
        foreach ($itens as $item) {
            ItemVenda::create(array_merge($item, ['venda_id' => $venda->id]));
        }

        return Redirect::route('vendas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venda = Venda::findOrFail($id);

        $clientesOptions = Cliente::options();
        $variedadesOptions = VariedadeFruta::options();
        $embalagensOptions = TipoEmbalagem::options();

        return view('vendas.edit', compact('venda', 'clientesOptions', 'variedadesOptions', 'embalagensOptions'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Vendas');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);

        $this->validate($request, Venda::$rules);

        $venda->update($request->all());

        ItemVenda::destroy($venda->itens->pluck('id')->all());

        $itens = collect($request->input('itens', []));
        foreach ($itens as $item) {
            ItemVenda::create(array_merge($item, ['venda_id' => $venda->id]));
        }

        return Redirect::route('vendas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Venda::destroy($id);

        return Redirect::route('vendas.index');
    }

    public function duplicate(Venda $venda)
    {
        $clientesOptions = Cliente::options();
        $variedadesOptions = VariedadeFruta::options();
        $embalagensOptions = TipoEmbalagem::options();

        $vendaNova = $venda->load('itens')->replicate();

        $venda = $vendaNova;

        return view('vendas.create', compact('venda', 'clientesOptions', 'variedadesOptions', 'embalagensOptions'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', "Duplicar venda");
    }


    public function relatorioVendas(Request $request)
    {
//        // Preparando a tabela de datas
//        DemonstracoesService::atualizarDatas();
//
//        // Preparando a tabela de saldos
//        $this->dispatch(new AtualizarSaldosMesesJob());
//
//        $contasOptions = Conta::contasOptions(0, [1, 2, 3]);
//        $mesesOptions = Data::mesesOptionsSelecione();
//
//        $contasFavoritasOptions = FavoritoBalancoPatrimonial::pluck('nome', 'id')->all();
//        $mesesFavoritosOptions = [];

        $frutasOptions = Fruta::frutasOptions();
        $frutasSelecionadas = collect($request->session()->get('frutas'));

        return view('vendas.relatorio_vendas.index', compact(
            'frutasOptions',
            'frutasSelecionadas'
        ));
    }

    public function dadosRelatorioVendas(Request $request)
    {
//        $horaCalculo = SaldoConta::min('hora_calculo');
//
        $this->atualizarDadosSession($request);

        $frutasIds = $request->session()->get('frutas');
        $dataInicial = $request->session()->get('dataInicial');
        $dataFinal = $request->session()->get('dataFinal');
        $groupBy = $request->session()->get('groupBy');
//        $mesesIds = $request->session()->get('meses');
//
//        $meses = Data::whereIn('id', $mesesIds)->orderBy('data')->get()->keyBy('id');
//
//        $contasAtivo = $this->contas('1', $contasIds);
//        $contasPassivo = $this->contas('2', $contasIds);
//        $contasPL = $this->contas('3', $contasIds);
//
//        $resultado = DemonstracoesService::balancoPatrimonialContas($contasIds, $mesesIds, $horaCalculo);
        $resultadoTotais = VendasService::totais($frutasIds, $dataInicial, $dataFinal, $groupBy);
        $resultadoSubTotais = VendasService::subTotais($frutasIds, $dataInicial, $dataFinal, $groupBy);

        $media = 'screen';
        $dataInicialFormatada = DateHelper::exibirData($dataInicial);
        $dataFinalFormatada = DateHelper::exibirData($dataFinal);
        return view('vendas.relatorio_vendas.partials.dados', compact(
            'resultadoTotais',
            'resultadoSubTotais',
            'dataInicialFormatada',
            'dataFinalFormatada',
            'media'
        ));
    }

    public function atualizarDadosSession(Request $request)
    {
        if (!$request->session()->has('frutas')) {
            session()->put('frutas', collect());
        }
        if ($request->has('frutas')) {
            session()->put('frutas', $request->input('frutas'));
        }
        
        if ($request->has('dataInicialFormatada')) {
            session()->put('dataInicial', DateHelper::extrairData($request->input('dataInicialFormatada')));
        } else {
            session()->put('dataInicial', Carbon::create(1900, 1, 1));
        }
        
        if ($request->has('dataFinalFormatada')) {
            session()->put('dataFinal', DateHelper::extrairData($request->input('dataFinalFormatada')));
        } else {
            session()->put('dataFinal', Carbon::create(2100, 12, 31));
        }

        if ($request->has('groupBy')) {
            session()->put('groupBy', $request->input('groupBy'));
        }
    }
}
