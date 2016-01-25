<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Auth::logout();
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
});

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('contas/importacao', 'ContasController@importacaoForm');
    Route::post('contas/importacao', 'ContasController@importacao');
    Route::get('contas/importacao_saldos', 'ContasController@importacaoSaldosForm');
    Route::post('contas/importacao_saldos', 'ContasController@importacaoSaldos');
    Route::get('contas/{conta}/lancamentos', ['as' => 'contas.lancamentos', 'uses' => 'LancamentosController@index']);
    Route::get('contas/{conta}/lancamentos/create/{tipo}', ['as' => 'contas.lancamentos.create', 'uses' => 'LancamentosController@create']);
    Route::post('contas/{conta}/lancamentos/create', ['as' => 'contas.lancamentos.store', 'uses' => 'LancamentosController@store']);
    Route::get('contas/{conta}/lancamentos/{lancamento}', ['as' => 'contas.lancamentos.edit', 'uses' => 'LancamentosController@edit']);
    Route::put('contas/{conta}/lancamentos/{lancamento}', ['as' => 'contas.lancamentos.update', 'uses' => 'LancamentosController@update']);
    Route::resource('contas', 'ContasController');
    Route::resource('favorecidos', 'FavorecidosController');
    Route::resource('lancamentos', 'LancamentosController');

    Route::get('balanco_patrimonial', 'DemonstracoesController@balancoPatrimonial');
    Route::any('atualizar_balanco_patrimonial', 'DemonstracoesController@atualizarBalancoPatrimonial');

    Route::resource('favoritos_balanco_patrimonial', 'FavoritosBalancoPatrimonialController');
    Route::resource('classificacoes_contas', 'ClassificacoesContasController');
});
