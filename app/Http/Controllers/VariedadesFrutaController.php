<?php

namespace App\Http\Controllers;

use App\Fruta;
use App\Http\Requests;
use App\VariedadeFruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VariedadesFrutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $variedadesFruta = VariedadeFruta::orderBy('nome')->get();

        return view('variedades_fruta.index', compact('variedadesFruta'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Variedades Fruta');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $frutasOptions = Fruta::all()->pluck('nome', 'id');

        return view('variedades_fruta.create', compact('variedade_fruta', 'frutasOptions'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Variedades Fruta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, VariedadeFruta::$rules);

        VariedadeFruta::create($request->all());

        return Redirect::route('variedades_fruta.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $variedadeFruta = VariedadeFruta::findOrFail($id);

        return view('variedades_fruta.edit', compact('variedadeFruta'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Variedades Fruta');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $variedadeFruta = VariedadeFruta::findOrFail($id);
        $frutasOptions = Fruta::all()->pluck('nome', 'id');

        return view('variedades_fruta.edit', compact('variedadeFruta', 'frutasOptions'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Variedades Fruta');
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
        $variedadeFruta = VariedadeFruta::findOrFail($id);

        $this->validate($request, VariedadeFruta::$rules);

        $variedadeFruta->update($request->all());

        return Redirect::route('variedades_fruta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        VariedadeFruta::destroy($id);

        return Redirect::route('variedades_fruta.index');
    }
}
