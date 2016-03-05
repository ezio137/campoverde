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
            ->with('modulo', 'Contábil')
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
            ->with('modulo', 'Contábil')
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
        if (!$this->isInteger($request->input('favorecido_id'))) {
            $favorecido = Favorecido::create(['nome' => $request->input('favorecido_id')]);
            $request->merge(['favorecido_id' => $favorecido->id]);
        }

        $this->validate($request, Lancamento::$rules);

        Lancamento::create($request->all());

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
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Lançamentos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Conta $conta, Lancamento $lancamento)
    {
        $favorecidosOptions = Favorecido::orderBy('nome')->pluck('nome', 'id');
        $contasOptions = Conta::contasOptions($conta->id);

        if ($lancamento->conta_credito_id == $conta->id) {
            $tipo = 'credito';
        } else {
            $tipo = 'debito';
        }

        if (($lancamento->conta_credito_id == $conta->id && $conta->aumentaComCredito) || ($lancamento->conta_debito_id == $conta->id && $conta->aumentaComDebito)) {
            $exibirTipo = 'Aumento';
        } else {
            $exibirTipo = 'Redução';
        }

        return view('lancamentos.edit', compact('lancamento', 'favorecidosOptions', 'contasOptions', 'tipo', 'conta'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "$exibirTipo em $conta->codigo_nome");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, Conta $conta, Lancamento $lancamento)
    {

        $this->validate($request, Lancamento::$rules);

        $lancamento->update($request->all());

        return Redirect::route('contas.lancamentos', ['conta' => $conta->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Lancamento $lancamento)
    {
        $lancamento->delete();

        return Redirect::route('contas.lancamentos', ['conta' => $lancamento->conta_id]);
    }

    private function isInteger($value)
    {
        return (string)(int)$value == $value;
    }

    public function getReconciliar(Conta $conta)
    {
        $lancamentos = Lancamento::where('conta_credito_id', $conta->id)->orWhere('conta_debito_id', $conta->id)->orderBy('data')->get();

        $saldo = 0.0;

        return view('contas.reconciliar', compact('lancamentos', 'conta', 'saldo'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Reconciliar - $conta->codigo_completo $conta->nome");
    }
}
