@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('breadcrumb')
    <li><a href="#">Cont&aacute;bil</a></li>
    <li><a href="#">Balan&ccedil;o Patrimonial</a></li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box ui-draggable ui-droppable">
                <div class="box-header">
                    <div class="box-name"></div>
                    <div class="box-icons"></div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    <div class="row">
                        <h2 class="text-center">Balan&ccedil;o Patrimonial</h2>
                    </div>
                    <div class="row" id="conteudo-demonstracao">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="box ui-draggable ui-droppable">
                <div class="box-header">
                    <div class="box-name"></div>
                    <div class="box-icons"></div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    <fieldset>
                        <legend>Incluir</legend>
                        {{ csrf_field() }}
                        <div class="row">
                            @include('layouts.forms.select', ['atributo' => 'conta', 'label' => 'Conta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
                        </div>
                        <div class="row">
                            @include('layouts.forms.select', ['atributo' => 'mes', 'label' => 'Mês', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $mesesOptions])
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="box ui-draggable ui-droppable">
                <div class="box-header">
                    <div class="box-name"></div>
                    <div class="box-icons"></div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    <fieldset>
                        <legend>Favoritos</legend>
                        {{ csrf_field() }}
                        <div class="row form-group-inline">
                            @include('layouts.forms.select', ['atributo' => 'contas_favoritas', 'label' => 'Conta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasFavoritasOptions, 'inline' => 'true'])
                            <a href="/favoritos_balanco_patrimonial/create" class="btn btn-primary btn-sm"><i
                                        class="fa fa-save"></i> Salvar favorito</a>
                        </div>
                        <div class="row">
                            @include('layouts.forms.select', ['atributo' => 'meses_favoritos', 'label' => 'Mês', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $mesesFavoritosOptions])
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

            $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial');

            $('#conta').change(function () {
                $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial', {
                    'conta': $('#conta').val(),
                    '_token': $('[name=_token]').val()
                })
            });
            $('#mes').change(function () {
                $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial', {
                    'mes': $('#mes').val(),
                    '_token': $('[name=_token]').val()
                })
            });
            $('#contas_favoritas').change(function () {
                $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial', {
                    'contas_favoritas': $('#contas_favoritas').val(),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('mouseenter mouseleave', 'th,td', function () {
                $(this).find('i').toggleClass('hidden');
            });

            $('#conteudo-demonstracao').on('click', 'tr.contas i', function () {
                $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial', {
                    'remove-conta': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('click', 'tr.meses i', function () {
                $('#conteudo-demonstracao').load('/atualizar_balanco_patrimonial', {
                    'remove-mes': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });
        });
    </script>
@stop