<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Http\Requests;
use App\Jobs\ImportarContas;
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

        return view('contas_contabil.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $contasOptions = Conta::contasOptions();

        $conta = null;

        return view('contas_contabil.create', compact('contasOptions', 'conta'));
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

        return Redirect::route('contas_contabil.index');
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

        return view('contas_contabil.edit', compact('conta'));
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

        $contasOptions = Conta::contasOptions($conta->id);

        return view('contas_contabil.edit', compact('conta', 'contasOptions'));
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

        return Redirect::route('contas_contabil.index');
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

        return Redirect::route('contas_contabil.index');
    }

    public function importacaoForm()
    {
        return view('contas_contabil.importacao');
    }

    public function importacao(Request $request)
    {
        $arquivo = $request->file('arquivo');

        $filename = Carbon::now()->format('Y-m-d_H-i-s') . '_' . $arquivo->getClientOriginalName();

        $arquivo->move('../storage/importacao', $filename);

        $path = storage_path('importacao/' . $filename);

        $this->dispatch(new ImportarContas($path));

        return Redirect::route('contas_contabil.index');
    }
}
