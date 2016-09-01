<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
});

Route::group(['middleware' => ['web', 'auth']], function () {

    // CONTABIL
    Route::get('anexo/{anexo}', ['as' => 'anexo.download', 'uses' => 'LancamentosController@anexo']);
    Route::get('contas/importacao', 'ContasController@importacaoForm');
    Route::post('contas/importacao', 'ContasController@importacao');
    Route::get('contas/importacao_saldos', 'ContasController@importacaoSaldosForm');
    Route::post('contas/importacao_saldos', 'ContasController@importacaoSaldos');
    Route::get('contas/{conta}/lancamentos', ['as' => 'contas.lancamentos', 'uses' => 'LancamentosController@index']);
    Route::get('contas/{conta}/lancamentos/create/{tipo}', ['as' => 'contas.lancamentos.create', 'uses' => 'LancamentosController@create']);
    Route::get('contas/{conta}/lancamentos/duplicate/{tipo}/{lancamento}', ['as' => 'contas.lancamentos.duplicate', 'uses' => 'LancamentosController@duplicate']);
    Route::post('contas/{conta}/lancamentos/create', ['as' => 'contas.lancamentos.store', 'uses' => 'LancamentosController@store']);
    Route::get('contas/{conta}/lancamentos/{lancamento}', ['as' => 'contas.lancamentos.edit', 'uses' => 'LancamentosController@edit']);
    Route::put('contas/{conta}/lancamentos/{lancamento}', ['as' => 'contas.lancamentos.update', 'uses' => 'LancamentosController@update']);
    Route::get('contas/{conta}/reconciliar', ['as' => 'contas.reconciliar', 'uses' => 'LancamentosController@getReconciliar']);
    Route::resource('contas', 'ContasController');
    Route::get('favorecidos/list', 'FavorecidosController@lists');
    Route::resource('favorecidos', 'FavorecidosController');
    Route::resource('lancamentos', 'LancamentosController');

    Route::get('lancamentos_futuros/{lancamentoFuturo}/preparar', 'LancamentosFuturosController@preparar');
    Route::post('lancamentos_futuros/{lancamentoFuturo}/registrar', ['as' => 'lancamentos_futuros.registrar', 'uses' => 'LancamentosFuturosController@registrar']);
    Route::resource('lancamentos_futuros', 'LancamentosFuturosController');

    Route::resource('contas_a_pagar', 'ContasAPagarController');

    Route::get('balanco_patrimonial', 'DemonstracoesController@balancoPatrimonial');
    Route::any('balanco_patrimonial/dados', 'DemonstracoesController@dadosBalancoPatrimonial');
    Route::any('balanco_patrimonial/pdf', 'DemonstracoesController@relatorioBalancoPatrimonial');

    Route::get('resultado', 'DemonstracoesController@resultado');
    Route::any('resultado/dados', 'DemonstracoesController@dadosResultado');
    Route::any('resultado/pdf', 'DemonstracoesController@relatorioResultado');

    Route::resource('favoritos_balanco_patrimonial', 'FavoritosBalancoPatrimonialController');
    Route::resource('favoritos_resultado', 'FavoritosResultadoController');
    Route::resource('classificacoes_contas', 'ClassificacoesContasController');

    Route::get('pesquisa', 'PesquisaController@index');

    // VENDAS
    Route::resource('vendas', 'VendasController');
    // Route::resource('tipos_embalagem', 'TiposEmbalagemController');
    // Route::resource('materiais_embalagem', 'MateriaisEmbalagemController');

    // AGRO
    Route::resource('frutas', 'FrutasController');
    Route::resource('variedades_fruta', 'VariedadesFrutaController');

});
Auth::routes();

Route::get('/home', 'HomeController@index');
