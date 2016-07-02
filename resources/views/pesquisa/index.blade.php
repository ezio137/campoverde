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
                    <th>Favorecido</th>
                    <th>Conta Origem</th>
                    <th>Conta Destino</th>
                    <th class="valor">Aumento</th>
                    <th class="valor">Redução</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lancamentos as $lancamento)
                    <tr>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->data_formatada, ['conta' => $lancamento->conta_debito_id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->favorecido->nome, ['conta' => $lancamento->conta_debito_id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $lancamento->contaCredito->codigoNome, ['conta' => $lancamento->conta_credito_id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $lancamento->contaDebito->codigoNome, ['conta' => $lancamento->conta_debito_id]) !!}</td>
                        <td class="valor">@if($lancamento->aumentaConta($lancamento->conta_debito_id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valorFormatado, ['conta' => $lancamento->conta_debito_id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td class="valor">@if(!$lancamento->aumentaConta($lancamento->conta_debito_id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valorFormatado, ['conta' => $lancamento->conta_debito_id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td>
                            {!! Form::open(['route' => ['lancamentos.destroy', $lancamento->id], 'method' => 'DELETE', 'id' => "delete-form-$lancamento->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $lancamento->id }}"><i class="fa fa-trash-o"></i></button>
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

@stop