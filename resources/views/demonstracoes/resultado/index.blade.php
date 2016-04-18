@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('breadcrumb')
    <li><a href="#">Cont&aacute;bil</a></li>
    <li><a href="#">Resultado</a></li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <h2 class="text-center">Resultado</h2>
                    </div>
                    <div class="row" id="conteudo-demonstracao">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="box box-success">
                <div class="box-body">
                    <fieldset>
                        <legend>Incluir</legend>
                        {{ csrf_field() }}
                        <div class="row">
                            @include('layouts.forms.select', ['atributo' => 'conta', 'label' => 'Conta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
                        </div>
                        <div class="row">
                            @include('layouts.forms.select', ['atributo' => 'mes_inicio', 'label' => 'Período', 'larguraAtributo' => 4, 'larguraLabel' => 2, 'options' => $mesesOptions, 'inline' => true])
                            @include('layouts.forms.select', ['atributo' => 'mes_fim', 'label' => 'a', 'larguraAtributo' => 4, 'larguraLabel' => 1, 'options' => $mesesOptions, 'inline' => true])
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="box box-success">
                <div class="box-body">
                    <fieldset>
                        <legend>Favoritos</legend>
                        {{ csrf_field() }}
                        <div class="row form-group-inline">
                            @include('layouts.forms.select', ['atributo' => 'contas_favoritas', 'label' => 'Favoritos', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasFavoritasOptions, 'inline' => 'true'])
                            <a href="/favoritos_resultado/create" class="btn btn-primary btn-sm"><i
                                        class="fa fa-save"></i> Salvar favorito</a>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
    <script type="application/javascript">
        $(function () {
            $('#conta').select2();
            $('#mes_inicio').select2();
            $('#mes_fim').select2();
            $('#contas_favoritas').select2();
            $('#meses_favoritos').select2();

            $('#conteudo-demonstracao').load('/resultado/dados');

            $('#conta').change(function () {
                $('#conteudo-demonstracao').load('/resultado/dados', {
                    'conta_resultado': $('#conta').val(),
                    '_token': $('[name=_token]').val()
                })
            });
            $('#mes_fim').change(function () {
                $('#conteudo-demonstracao').load('/resultado/dados', {
                    'mes_inicio': $('#mes_inicio').val(),
                    'mes_fim': $('#mes_fim').val(),
                    '_token': $('[name=_token]').val()
                })
            });
            $('#contas_favoritas').change(function () {
                $('#conteudo-demonstracao').load('/resultado/dados', {
                    'contas_favoritas_resultado': $('#contas_favoritas').val(),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('mouseenter mouseleave', 'th,td', function () {
                $(this).find('i').toggleClass('hidden');
            });

            $('#conteudo-demonstracao').on('click', 'tr.contas i', function () {
                $('#conteudo-demonstracao').load('/resultado/dados', {
                    'remove-conta-resultado': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('click', 'tr.meses i', function () {
                $('#conteudo-demonstracao').load('/resultado/dados', {
                    'remove-periodo': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });
        });
    </script>
@stop

@section('botoes-footer')
    <a href="/resultado/pdf" class="btn btn-success"><i class="fa fa-file-text-o"></i> Imprimir</a>
@stop