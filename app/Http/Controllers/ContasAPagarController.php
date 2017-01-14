<?php

namespace App\Http\Controllers;

use App\Conta;
use App\ContaAPagar;
use App\Favorecido;
use App\Http\Requests;
use App\Periodicidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ContasAPagarController extends Controller
{
    public function index()
    {
        $contasAPagarRaw = DB::table('contas_a_pagar')
            ->join('favorecidos', 'favorecidos.id', '=', 'contas_a_pagar.favorecido_id')
            ->select(DB::raw('contas_a_pagar.*'))
            ->orderBy('favorecidos.nome')
            ->orderBy('contas_a_pagar.data_proxima')
            ->get();
        $contasAPagar = ContaAPagar::hydrate($contasAPagarRaw->all());

        return view('contas_a_pagar.index', compact('contasAPagar'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Configuração de Contas a Pagar');
    }

    public function create()
    {
        $contaAPagar = new ContaAPagar();
        $contaAPagar->parcela_atual = 1;
        $contaAPagar->parcela_total = 1;

        $favorecidosOptions = Favorecido::orderBy('nome')->pluck('nome', 'id');
        $contasOptions = Conta::contasOptions();
        $periodicidadesOptions = Periodicidade::periodicidadesOptions();

        return view('contas_a_pagar.create', compact('contaAPagar', 'favorecidosOptions', 'contasOptions', 'periodicidadesOptions'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Contas a Pagar');
    }

    public function store(Request $request)
    {
        $this->validate($request, []);

        ContaAPagar::create($request->all());

        return Redirect::route('contas_a_pagar.index');
    }

    public function edit(ContaAPagar $contas_a_pagar)
    {
        $contaAPagar = $contas_a_pagar;

        $favorecidosOptions = Favorecido::orderBy('nome')->pluck('nome', 'id');
        $contasOptions = Conta::contasOptions();
        $periodicidadesOptions = Periodicidade::periodicidadesOptions();

        return view('contas_a_pagar.edit', compact('contaAPagar', 'favorecidosOptions', 'contasOptions', 'periodicidadesOptions'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Conta a Pagar");
    }

    public function update(Request $request, ContaAPagar $contas_a_pagar)
    {
        $this->validate($request, []);

        $contas_a_pagar->update($request->all());

        return Redirect::route('contas_a_pagar.index');
    }

    public function destroy(ContaAPagar $contas_a_pagar)
    {
        $contas_a_pagar->delete();

        return Redirect::route('contas_a_pagar.index');
    }
}
