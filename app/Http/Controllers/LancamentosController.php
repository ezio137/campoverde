<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Favorecido;
use App\Lancamento;
use App\Http\Requests;
use App\Services\TextHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LancamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Conta $conta)
    {
        $lancamentos = Lancamento::where('conta_credito_id', $conta->id)->orWhere('conta_debito_id', $conta->id)->orderBy('data')->get();

        $operacaoAumento = $conta->aumentaComCredito ? 'credito' : 'debito';
        $operacaoReducao = $conta->aumentaComCredito ? 'debito' : 'credito';

        $saldo = 0.0;

        return view('lancamentos.index', compact('lancamentos', 'conta', 'operacaoAumento', 'operacaoReducao', 'saldo'))
            ->with('pageHeader', "Lançamentos - $conta->codigo_completo $conta->nome");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Conta $conta, $tipo)
    {
        $favorecidosOptions = Favorecido::orderBy('nome')->pluck('nome', 'id');
        $contasOptions = Conta::contasOptions($conta->id);

        if (($tipo == 'credito' && $conta->aumentaComCredito) || ($tipo == 'debito' && $conta->aumentaComDebito)) {
            $exibirTipo = 'Aumento';
        } else {
            $exibirTipo = 'Redução';
        }

        return view('lancamentos.create', compact('conta', 'tipo', 'favorecidosOptions', 'contasOptions'))
            ->with('pageHeader', "$exibirTipo em $conta->codigo_nome");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Conta $conta)
    {
        $this->validate($request, Lancamento::$rules);

        $lancamento = Lancamento::create($request->all());
        $contaCredito = $lancamento->contaCredito;
        $contaDebito = $lancamento->contaDebito;
        $contaCredito->aumentaComCredito
            ? $contaCredito->update(['saldo' => $contaCredito->saldo + $lancamento->valor])
            : $contaCredito->update(['saldo' => $contaCredito->saldo - $lancamento->valor]);
        $contaDebito->aumentaComDebito
            ? $contaDebito->update(['saldo' => $contaDebito->saldo + $lancamento->valor])
            : $contaDebito->update(['saldo' => $contaDebito->saldo - $lancamento->valor]);

        return Redirect::route('contas.lancamentos', ['conta' => $conta->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $lancamento = Lancamento::findOrFail($id);

        return view('lancamentos.edit', compact('lancamento'))
            ->with('pageHeader', 'Lançamentos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $lancamento = Lancamento::findOrFail($id);

        return view('lancamentos.edit', compact('lancamento'))
            ->with('pageHeader', 'Lançamentos');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $lancamento = Lancamento::findOrFail($id);

        $this->validate($request, Lancamento::$rules);

        $lancamento->update($request->all());

        return Redirect::route('lancamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Lancamento::destroy($id);

        return Redirect::route('lancamentos.index');
    }
}
