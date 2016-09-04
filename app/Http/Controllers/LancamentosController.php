<?php

namespace App\Http\Controllers;

use App\Anexo;
use App\Conta;
use App\Favorecido;
use App\Http\Requests;
use App\Lancamento;
use Illuminate\Http\Request;
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
        $favorecidosOptions = Favorecido::favorecidosOptions();
        $contasOptions = Conta::contasOptions($conta->id);
        $lancamentoNovo = new Lancamento();
        $lancamentoNovo->valor = 0.0;
        $lancamentoNovo->parcela_atual = 0;
        $lancamentoNovo->parcela_total = 0;

        if (($tipo == 'credito' && $conta->aumentaComCredito) || ($tipo == 'debito' && $conta->aumentaComDebito)) {
            $exibirTipo = 'Aumento';
        } else {
            $exibirTipo = 'Redução';
        }

        return view('lancamentos.create', compact('conta', 'tipo', 'favorecidosOptions', 'contasOptions', 'lancamentoNovo'))
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

        $lancamento = Lancamento::create($request->all());

        $arquivo = $request->file('anexo');

        if ($arquivo) {
            $nomeArquivo = $arquivo->getClientOriginalName();
            $extensao = $arquivo->getClientOriginalExtension();
            $tamanhoBytes = $arquivo->getClientSize();

            $anexo = Anexo::create([
                'nome' => 'Anexo',
                'extensao' => $extensao,
                'nome_original' => $nomeArquivo,
                'tamanho_bytes' => $tamanhoBytes,
                'anexavel_id' => $lancamento->id,
                'anexavel_type' => 'App\Lancamento',
            ]);

            $arquivo->move(storage_path('anexos'), $anexo->id);
        }

        return redirect("/contas/$conta->id/lancamentos#lancamento-$lancamento->id");
    }

    private function isInteger($value)
    {
        return (string)(int)$value == $value;
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
        $favorecidosOptions = Favorecido::favorecidosOptions();
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

        if (!$this->isInteger($request->input('favorecido_id'))) {
            $favorecido = Favorecido::create(['nome' => $request->input('favorecido_id')]);
            $request->merge(['favorecido_id' => $favorecido->id]);
        }

        $lancamento->update($request->all());

        $arquivo = $request->file('anexo');

        if ($arquivo) {
            $nomeArquivo = $arquivo->getClientOriginalName();
            $extensao = $arquivo->getClientOriginalExtension();
            $tamanhoBytes = $arquivo->getClientSize();

            $anexo = Anexo::create([
                'nome' => 'Anexo',
                'extensao' => $extensao,
                'nome_original' => $nomeArquivo,
                'tamanho_bytes' => $tamanhoBytes,
                'anexavel_id' => $lancamento->id,
                'anexavel_type' => 'App\Lancamento',
            ]);

            $arquivo->move(storage_path('anexos'), $anexo->id);
        }

        return redirect("/contas/$conta->id/lancamentos#lancamento-$lancamento->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $lancamento = Lancamento::find($id);
        $lancamento->delete();

        $contaId = $request->input('contaId');
        return Redirect::route('contas.lancamentos', ['conta' => $contaId]);
    }

    public function getReconciliar(Conta $conta)
    {
        $lancamentos = Lancamento::where('conta_credito_id', $conta->id)->orWhere('conta_debito_id', $conta->id)->orderBy('data')->get();

        $saldo = 0.0;

        return view('contas.reconciliar', compact('lancamentos', 'conta', 'saldo'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Reconciliar - $conta->codigo_completo $conta->nome");
    }

    public function anexo(Anexo $anexo)
    {
        return response()->download(storage_path('anexos').'/'.$anexo->id, $anexo->nome_original);
    }

    public function duplicate(Conta $conta, $tipo, Lancamento $lancamento)
    {
        $favorecidosOptions = Favorecido::favorecidosOptions();
        $contasOptions = Conta::contasOptions($conta->id);
        $lancamentoNovo = new Lancamento();
        $lancamentoNovo->fill($lancamento->getAttributes());

        if (($tipo == 'credito' && $conta->aumentaComCredito) || ($tipo == 'debito' && $conta->aumentaComDebito)) {
            $exibirTipo = 'Aumento';
        } else {
            $exibirTipo = 'Redução';
        }

        return view('lancamentos.create', compact('conta', 'tipo', 'favorecidosOptions', 'contasOptions', 'lancamentoNovo'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Duplicar $exibirTipo em $conta->codigo_nome");
    }
}
