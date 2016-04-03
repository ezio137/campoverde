<?php

namespace App\Http\Controllers;

use App\Conta;
use App\FavoritoBalancoPatrimonial;
use App\Http\Requests;
use App\ItemFavoritoBalancoPatrimonial;
use Illuminate\Http\Request;

class FavoritosBalancoPatrimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $contas = Conta::whereIn('id', $request->session()->get('contas'))->get();
        return view('favoritos_balanco_patrimonial.create', compact('contas'))
            ->with('modulo', 'Contábil')
            ->with('pageHeader', "Favorito");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, FavoritoBalancoPatrimonial::$rules);

        $favorito = FavoritoBalancoPatrimonial::create($request->all());

        foreach ($request->session()->get('contas') as $contaId) {
            ItemFavoritoBalancoPatrimonial::create([
                'favorito_bp_id' => $favorito->id,
                'conta_codigo_completo' => Conta::find($contaId)->codigo_completo
            ]);
        }

        return redirect('/balanco_patrimonial');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
