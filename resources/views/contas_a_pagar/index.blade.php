@inject('dateHelper', 'App\Services\DateHelper')
@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed table-striped small">
                <thead>
                <tr>
                    <th>Favorecido</th>
                    <th>Data Próxima</th>
                    <th>Parcela Próxima</th>
                    <th>Conta Origem</th>
                    <th>Conta Destino</th>
                    <th class="valor">Aumento</th>
                    <th class="valor">Redução</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $saldo = 0.0; ?>
                @foreach($contasAPagar as $contaAPagar)
                    <tr>
                        <td>{!! link_to_route('contas_a_pagar.edit', $contaAPagar->favorecido->nome, ['contaAPagar' => $contaAPagar->id]) !!}</td>
                        <td>{!! link_to_route('contas_a_pagar.edit', $contaAPagar->data_proxima_formatada, ['contaAPagar' => $contaAPagar->id]) !!}</td>
                        <td>{!! link_to_route('contas_a_pagar.edit', $contaAPagar->parcela_formatada, ['contaAPagar' => $contaAPagar->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $contaAPagar->contaCredito->codigoNome, ['conta' => $contaAPagar->conta_credito_id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $contaAPagar->contaDebito->codigoNome, ['conta' => $contaAPagar->conta_debito_id]) !!}</td>
                        <td class="valor">@if($contaAPagar->aumentaConta($contaAPagar->conta_credito_id)) {!! link_to_route('contas_a_pagar.edit', $contaAPagar->valorFormatado, ['contaAPagar' => $contaAPagar->id]) !!} @endif</td>
                        <td class="valor">@if(!$contaAPagar->aumentaConta($contaAPagar->conta_credito_id)) {!! link_to_route('contas_a_pagar.edit', $contaAPagar->valorFormatado, ['contaAPagar' => $contaAPagar->id]) !!} @endif</td>
                        <td>
                            {!! Form::open(['route' => ['contas_a_pagar.destroy', $contaAPagar->id], 'method' => 'DELETE', 'id' => "delete-form-$contaAPagar->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $contaAPagar->id }}"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('botoes-footer')
    <a href="/contas_a_pagar/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova Conta a Pagar</a>
    <a href="/lancamentos_futuros" class="btn btn-success"><i class="fa fa-calendar-check-o"></i> Próximas Contas a
        Pagar</a>
@stop