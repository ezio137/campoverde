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

Route::get('/', function () {
    return view('home');
});

Route::get('contas/importacao', 'ContasController@importacaoForm');
Route::post('contas/importacao', 'ContasController@importacao');
Route::get('contas/importacao_saldos', 'ContasController@importacaoSaldosForm');
Route::post('contas/importacao_saldos', 'ContasController@importacaoSaldos');
Route::get('contas/{conta}/lancamentos', ['as' => 'contas.lancamentos', 'uses' => 'LancamentosController@index']);
Route::get('contas/{conta}/lancamentos/create/{tipo}', ['as' => 'contas.lancamentos.create', 'uses' => 'LancamentosController@create']);
Route::post('contas/{conta}/lancamentos/create', ['as' => 'contas.lancamentos.store', 'uses' => 'LancamentosController@store']);
Route::resource('contas', 'ContasController');
Route::resource('favorecidos', 'FavorecidosController');
Route::resource('lancamentos', 'LancamentosController');

Route::get('balanco_patrimonial', 'DemonstracoesController@balancoPatrimonial');
Route::any('atualizar_balanco_patrimonial', 'DemonstracoesController@atualizarBalancoPatrimonial');

Route::resource('favoritos_balanco_patrimonial', 'FavoritosBalancoPatrimonialController');
Route::resource('classificacoes_contas', 'ClassificacoesContasController');