<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Lancamento;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LancamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Conta $id)
    {
        dd($id);
        $lancamentos = Lancamento::orderBy('data')->get();

        return view('lancamentos.index', compact('lancamentos', 'conta'))
            ->with('pageHeader', "Lançamentos - $id->nome");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $conta = null;

        return view('lancamentos.create', compact('lancamento'))
            ->with('pageHeader', 'Lançamentos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Lancamento::$rules);

        Lancamento::create($request->all());

        return Redirect::route('lancamentos.index');
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
