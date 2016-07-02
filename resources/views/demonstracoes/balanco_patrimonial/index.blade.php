@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('breadcrumb')
    <li><a href="#">Cont&aacute;bil</a></li>
    <li><a href="#">Balan&ccedil;o Patrimonial</a></li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <h2 class="text-center">Balanço Patrimonial</h2>
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
                    <form class="form-horizontal">
                        <fieldset>
                            <legend>Incluir</legend>
                            {{ csrf_field() }}
                            <div class="row">
                                @include('layouts.forms.select', ['atributo' => 'conta', 'label' => 'Conta', 'larguraAtributo' => 7, 'larguraLabel' => 2, 'options' => $contasOptions])
                            </div>
                            <div class="row">
                                @include('layouts.forms.select', ['atributo' => 'mes', 'label' => 'Mês', 'larguraAtributo' => 7, 'larguraLabel' => 2, 'options' => $mesesOptions])
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-3">
                                    <a href="#" id="adicionar-relatorio" class="btn btn-primary btn-sm"><i
                                                class="fa fa-plus"></i> Adicionar ao relatório</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
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
                            <a href="/favoritos_balanco_patrimonial/create" class="btn btn-primary btn-sm"><i
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
            $('#mes').select2();
            $('#contas_favoritas').select2();
            $('#meses_favoritos').select2();

            $('#conteudo-demonstracao').load('/balanco_patrimonial/dados');

            $('#adicionar-relatorio').click(function () {
                $('#conteudo-demonstracao').load('/balanco_patrimonial/dados', {
                    'conta': $('#conta').val(),
                    'mes': $('#mes').val(),
                    '_token': $('[name=_token]').val()
                });
                return false;
            });
            $('#contas_favoritas').change(function () {
                $('#conteudo-demonstracao').load('/balanco_patrimonial/dados', {
                    'contas_favoritas': $('#contas_favoritas').val(),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('mouseenter mouseleave', 'th,td', function () {
                $(this).find('i').toggleClass('hidden');
            });

            $('#conteudo-demonstracao').on('click', 'tr.contas i', function () {
                $('#conteudo-demonstracao').load('/balanco_patrimonial/dados', {
                    'remove-conta': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('click', 'tr.meses i', function () {
                $('#conteudo-demonstracao').load('/balanco_patrimonial/dados', {
                    'remove-mes': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });
        });
    </script>
@stop

@section('botoes-footer')
    <a href="/balanco_patrimonial/pdf" class="btn btn-success"><i class="fa fa-file-text-o"></i> Imprimir</a>
@stop