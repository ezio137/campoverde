<?php

namespace App\Http\Controllers;

use App\ClassificacaoFruta;
use App\MaterialEmbalagem;
use App\TipoEmbalagem;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class TiposEmbalagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposEmbalagem = TipoEmbalagem::orderBy('nome')->get();

        return view('tipos_embalagem.index', compact('tiposEmbalagem'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Tipos Embalagem');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materiaisOptions = MaterialEmbalagem::options();
        $classificacoesOptions = ClassificacaoFruta::options();

        return view('tipos_embalagem.create', compact('variedade_fruta', 'materiaisOptions', 'classificacoesOptions'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Tipos Embalagem');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, TipoEmbalagem::$rules);

        TipoEmbalagem::create($request->all());

        return Redirect::route('tipos_embalagem.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoEmbalagem = TipoEmbalagem::findOrFail($id);
        $materiaisOptions = MaterialEmbalagem::options();
        $classificacoesOptions = ClassificacaoFruta::options();

        return view('tipos_embalagem.edit', compact('tipoEmbalagem', 'materiaisOptions', 'classificacoesOptions'))
            ->with('modulo', 'Vendas')
            ->with('pageHeader', 'Tipos Embalagem');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoEmbalagem = TipoEmbalagem::findOrFail($id);

        $this->validate($request, TipoEmbalagem::$rules);

        $tipoEmbalagem->update($request->all());

        return Redirect::route('tipos_embalagem.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipoEmbalagem::destroy($id);

        return Redirect::route('tipos_embalagem.index');
    }
}
