@inject('dateHelper', 'App\Services\DateHelper')
@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('content')
    @if($conta->id)
        <div class="row">
            <div class="col-xs-12">
                <a href="/contas/{{ $conta->id }}/lancamentos/create/{{ $operacaoAumento }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo aumento</a>
                <a href="/contas/{{ $conta->id }}/lancamentos/create/{{ $operacaoReducao }}" class="btn btn-success"><i class="fa fa-plus"></i> Nova redu&ccedil;&atilde;o</a>
            </div>
        </div>
    @endif

    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed small">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Favorecido</th>
                    <th>Conta</th>
                    <th>Aumento</th>
                    <th>Redu&ccedil;&atilde;o</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lancamentos as $lancamento)
                    <?php
                            if($lancamento->aumentaConta($conta->id)) {
                                $saldo += $lancamento->valor;
                            } else {
                                $saldo -= $lancamento->valor;
                            }
                    ?>
                    <tr>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->data, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->favorecido->nome, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $conta->id == $lancamento->conta_credito_id ? $lancamento->contaDebito->codigoNome : $lancamento->contaCredito->codigoNome, ['conta' => $conta->id == $lancamento->conta_credito_id ? $lancamento->conta_debito_id : $lancamento->conta_credito_id]) !!}</td>
                        <td>@if($lancamento->aumentaConta($conta->id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valor, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td>@if(!$lancamento->aumentaConta($conta->id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valor, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td>{{ $numberHelper::exibirDecimal($saldo) }}</td>
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