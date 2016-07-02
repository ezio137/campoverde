<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lancamento;
use Illuminate\Http\Request;

class PesquisaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $lancamentos = Lancamento::where('memorando', 'like', "%$query%")
            ->orWhere('documento', 'like', "%$query%")
            ->orderBy('data')->get();

        return view('pesquisa.index', compact('lancamentos'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Resultado da pesquisa");
    }
}
