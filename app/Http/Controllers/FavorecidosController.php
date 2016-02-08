<?php

namespace App\Http\Controllers;

use App\Favorecido;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class FavorecidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $favorecidos = Favorecido::orderBy('nome')->get();

        return view('favorecidos.index', compact('favorecidos'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Favorecidos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $conta = null;

        return view('favorecidos.create', compact('favorecido'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Favorecidos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Favorecido::$rules);

        Favorecido::create($request->all());

        return Redirect::route('favorecidos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $favorecido = Favorecido::findOrFail($id);

        return view('favorecidos.edit', compact('favorecido'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Favorecidos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $favorecido = Favorecido::findOrFail($id);

        return view('favorecidos.edit', compact('favorecido'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', 'Favorecidos');
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
        $favorecido = Favorecido::findOrFail($id);

        $this->validate($request, Favorecido::$rules);

        $favorecido->update($request->all());

        return Redirect::route('favorecidos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Favorecido::destroy($id);

        return Redirect::route('favorecidos.index');
    }

    public function lists(Request $request)
    {
        $novo = collect(['id' => 0, 'text' => $request->input('term')]);
        $lista = Favorecido::orderBy('nome')->select(DB::raw('nome as text'), 'id')->get();

        return array_merge([$novo->all()], $lista->all());
    }
}
