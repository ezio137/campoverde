@inject('dateHelper', 'App\Services\DateHelper')
@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed table-striped small">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Parcela</th>
                    <th>Favorecido</th>
                    <th>Conta Origem</th>
                    <th>Conta Destino</th>
                    <th class="valor">Aumento</th>
                    <th class="valor">Redução</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $saldo = 0.0; ?>
                @foreach($lancamentos as $lancamento)
                    <tr>
                        <td>{!! link_to_route('contas_a_pagar.edit', $lancamento->data_formatada, ['contaAPagar' => $lancamento->conta_a_pagar_id]) !!}</td>
                        <td>{!! link_to_route('contas_a_pagar.edit', $lancamento->parcela_formatada, ['contaAPagar' => $lancamento->conta_a_pagar_id]) !!}</td>
                        <td>{!! link_to_route('contas_a_pagar.edit', $lancamento->favorecido->nome, ['contaAPagar' => $lancamento->conta_a_pagar_id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $lancamento->contaCredito->codigoNome, ['conta' => $lancamento->conta_credito_id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $lancamento->contaDebito->codigoNome, ['conta' => $lancamento->conta_debito_id]) !!}</td>
                        <td class="valor">@if($lancamento->aumentaConta($lancamento->conta_credito_id)) {!! link_to_route('contas_a_pagar.edit', $lancamento->valorFormatado, ['contaAPagar' => $lancamento->conta_a_pagar_id]) !!} @endif</td>
                        <td class="valor">@if(!$lancamento->aumentaConta($lancamento->conta_credito_id)) {!! link_to_route('contas_a_pagar.edit', $lancamento->valorFormatado, ['contaAPagar' => $lancamento->conta_a_pagar_id]) !!} @endif</td>
                        <td><a href="/lancamentos_futuros/{{ $lancamento->id }}/preparar" title="Registrar"><i
                                        class="fa fa-book"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('botoes-footer')
    <a href="/contas_a_pagar/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova conta a pagar</a>
    <a href="/contas_a_pagar" class="btn btn-success"><i class="fa fa-gear"></i> Configurar contas a pagar</a>
@stop