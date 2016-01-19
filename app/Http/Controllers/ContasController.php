<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Http\Requests;
use App\Jobs\ImportarContas;
use App\Jobs\ImportarSaldosContas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contas = Conta::orderBy('codigo_completo_ordenavel')->get();

        return view('contas.index', compact('contas'))
            ->with('pageHeader', 'Contas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $contasOptions = Conta::contasOptionsNenhum();

        $conta = null;

        return view('contas.create', compact('contasOptions', 'conta'))
            ->with('pageHeader', 'Contas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Conta::$rules);

        Conta::create($request->all());

        return Redirect::route('contas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $conta = Conta::findOrFail($id);

        return view('contas.edit', compact('conta'))
            ->with('pageHeader', 'Contas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $conta = Conta::findOrFail($id);

        $contasOptions = Conta::contasOptionsNenhum($conta->id);

        return view('contas.edit', compact('conta', 'contasOptions'))
            ->with('pageHeader', 'Contas');
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
        $conta = Conta::findOrFail($id);

        $this->validate($request, Conta::$rules);

        $conta->update($request->all());

        return Redirect::route('contas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Conta::destroy($id);

        return Redirect::route('contas.index');
    }

    public function importacaoForm()
    {
        return view('contas.importacao')
            ->with('pageHeader', 'Contas');
    }

    public function importacao(Request $request)
    {
        $arquivo = $request->file('arquivo');

        $filename = Carbon::now()->format('Y-m-d_H-i-s') . '_' . $arquivo->getClientOriginalName();

        $arquivo->move('../storage/importacao', $filename);

        $path = storage_path('importacao/' . $filename);

        $this->dispatch(new ImportarContas($path));

        return Redirect::route('contas.index');
    }

    public function importacaoSaldosForm()
    {
        return view('contas.importacao_saldos')
            ->with('pageHeader', 'Contas');
    }

    public function importacaoSaldos(Request $request)
    {
        $arquivo = $request->file('arquivo');

        $filename = Carbon::now()->format('Y-m-d_H-i-s') . '_' . $arquivo->getClientOriginalName();

        $arquivo->move('../storage/importacao', $filename);

        $path = storage_path('importacao/' . $filename);

        $this->dispatch(new ImportarSaldosContas($path));

        return Redirect::route('contas.index');
    }
}
