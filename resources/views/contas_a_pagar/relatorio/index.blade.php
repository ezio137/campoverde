@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('breadcrumb')
    <li><a href="#">Contábil</a></li>
    <li><a href="#">Contas a Pagar</a></li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <h2 class="text-center">Contas a Pagar</h2>
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
                                De {!! Form::text('dataInicialFormatada', $dataInicialFormatada) !!} a {!! Form::text('dataFinalFormatada') !!}
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-1">
                                    @foreach($contasOptions as $id => $conta)
                                        <?php $options = $contasSelecionadas->contains($id) ? ['checked' => 'checked'] : [] ?>
                                        {!! Form::checkbox('contas', $id, $options) !!}
                                        <span>{{ $conta }}</span><br>
                                    @endforeach
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
                            <div class="col-sm-offset-1">

                            </div>
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
                var contas = [];
                $('[name=contas]:checked').each(function(){
                    contas.push($(this).val());
                });
                $('#conteudo-demonstracao').load('/contas_a_pagar/relatorio/dados', {
                    'contas': contas,
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

            $('#conteudo-demonstracao').load('/contas_a_pagar/relatorio/dados');

            $('#atualizar-contas-relatorio').click(atualizarRelatorio);

            $('.groupBy').click(function () {
                var element = $(this);
                $('#conteudo-demonstracao').load('/contas_a_pagar/relatorio/dados', {
                    'groupBy': element.data('group-by'),
                    '_token': $('[name=_token]').val()
                });
                return false;
            });

            $('#conteudo-demonstracao').on('mouseenter mouseleave', 'th,td', function () {
                $(this).find('i').toggleClass('hidden');
            });

            $('#conteudo-demonstracao').on('click', 'tr.contas i', function () {
                $('#conteudo-demonstracao').load('/contas_a_pagar/relatorio/dados', {
                    'remove-conta': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });

            $('#conteudo-demonstracao').on('click', 'tr.meses i', function () {
                $('#conteudo-demonstracao').load('/contas_a_pagar/relatorio/dados', {
                    'remove-mes': $(this).data('id'),
                    '_token': $('[name=_token]').val()
                })
            });
        });
    </script>
@stop

@section('botoes-footer')
    <a href="#" id="atualizar-contas-relatorio" class="btn btn-success"><i
                class="fa fa-refresh"></i> Atualizar relatório</a>
@stop