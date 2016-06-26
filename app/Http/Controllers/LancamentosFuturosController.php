<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Favorecido;
use App\Http\Requests;
use App\Lancamento;
use App\LancamentoFuturo;

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
}
