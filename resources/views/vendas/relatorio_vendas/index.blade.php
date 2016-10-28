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
                        <h2 class="text-center">Vendas</h2>
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
                            <legend>Filtros</legend>
                            {{ csrf_field() }}
                            <div>
                                De {!! Form::text('dataInicialFormatada') !!} a {!! Form::text('dataFinalFormatada') !!}
                            </div>
                            <div class="row">
                                @foreach($frutasOptions as $id => $fruta)
                                    <?php $options = $frutasSelecionadas->contains($id) ? ['checked' => 'checked'] : [] ?>
                                    {!! Form::checkbox('frutas', $id, $options) !!}
                                    <span>{{ $fruta }}</span><br>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-3">
                                    <a href="#" id="atualizar-frutas-relatorio" class="btn btn-primary btn-sm"><i
                                                class="fa fa-refresh"></i> Atualizar relatório</a>
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
                        <legend>Subtotais</legend>
                        {{ csrf_field() }}
                        <div class="row" id="subtotais">
                            <a href="#" class="groupBy" data-group-by="cliente">Cliente</a><br>
                            <a href="#" class="groupBy" data-group-by="tipoFruta">Tipo Fruta</a>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
    <script>
        $(function () {
            function atualizarRelatorio() {
                var frutas = [];
                $('[name=frutas]:checked').each(function(){
                    frutas.push($(this).val());
                });
                $('#conteudo-demonstracao').load('/relatorio_vendas/dados', {
                    'frutas': frutas,
                    'dataInicialFormatada': $('[name=dataInicialFormatada]').val(),
                    'dataFinalFormatada': $('[name=dataFinalFormatada]').val(),
                    '_token': $('[name=_token]').val()
                });
                return false;
            }

            $('[name=dataInicialFormatada]').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('[name=dataFinalFormatada]').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });

            $('#conteudo-demonstracao').load('/relatorio_vendas/dados');

            $('#atualizar-frutas-relatorio').click(atualizarRelatorio);

            $('.groupBy').click(function () {
                var element = $(this);
                $('#conteudo-demonstracao').load('/relatorio_vendas/dados', {
                    'groupBy': element.data('group-by'),
                    '_token': $('[name=_token]').val()
                });
                return false;
            });

            $('#conteudo-demonstracao').on('mouseenter mouseleave', 'th,td', function () {
                $(this).find('i').toggleClass('hidden');
            });

            $('#conteudo-demonstracao').on('click', 'tr.contas i', function () {
                $('#conteudo-demonstracao').load('/relatorio_vendas/dados', {
                    'remove-conta': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('click', 'tr.meses i', function () {
                $('#conteudo-demonstracao').load('/relatorio_vendas/dados', {
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