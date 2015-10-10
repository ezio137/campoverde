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

Route::get('contas_contabil/importacao', 'ContasController@importacaoForm');
Route::post('contas_contabil/importacao', 'ContasController@importacao');
Route::get('contas_contabil/importacao_saldos', 'ContasController@importacaoSaldosForm');
Route::post('contas_contabil/importacao_saldos', 'ContasController@importacaoSaldos');
Route::resource('contas_contabil', 'ContasController');

Route::get('balanco_patrimonial', 'DemonstracoesController@balancoPatrimonial');
Route::any('atualizar_balanco_patrimonial', 'DemonstracoesController@atualizarBalancoPatrimonial');