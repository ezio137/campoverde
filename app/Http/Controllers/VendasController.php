<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests;
use App\ItemVenda;
use App\TipoEmbalagem;
use App\VariedadeFruta;
use App\Venda;
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
}
