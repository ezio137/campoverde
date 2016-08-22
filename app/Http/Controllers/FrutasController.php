<?php

namespace App\Http\Controllers;

use App\Fruta;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FrutasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $frutas = Fruta::orderBy('nome')->get();

        return view('frutas.index', compact('frutas'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Frutas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $conta = null;

        return view('frutas.create', compact('fruta'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Frutas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Fruta::$rules);

        Fruta::create($request->all());

        return Redirect::route('frutas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $fruta = Fruta::findOrFail($id);

        return view('frutas.edit', compact('fruta'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Frutas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $fruta = Fruta::findOrFail($id);

        return view('frutas.edit', compact('fruta'))
            ->with('modulo', 'Agro')
            ->with('pageHeader', 'Frutas');
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
        $fruta = Fruta::findOrFail($id);

        $this->validate($request, Fruta::$rules);

        $fruta->update($request->all());

        return Redirect::route('frutas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Fruta::destroy($id);

        return Redirect::route('frutas.index');
    }
}
