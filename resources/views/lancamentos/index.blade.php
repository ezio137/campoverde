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
                    <th>Conta</th>
                    <th class="valor">Aumento</th>
                    <th class="valor">Redu&ccedil;&atilde;o</th>
                    <th class="valor">Saldo</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $saldo = 0.0; ?>
                @foreach($lancamentos as $lancamento)
                    <?php
                            if($lancamento->aumentaConta($conta->id)) {
                                $saldo += $lancamento->valor;
                            } else {
                                $saldo -= $lancamento->valor;
                            }
                    ?>
                    <tr>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->data_formatada, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos.edit', $lancamento->favorecido->nome, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('contas.lancamentos', $conta->id == $lancamento->conta_credito_id ? $lancamento->contaDebito->codigoNome : $lancamento->contaCredito->codigoNome, ['conta' => $conta->id == $lancamento->conta_credito_id ? $lancamento->conta_debito_id : $lancamento->conta_credito_id]) !!}</td>
                        <td class="valor">@if($lancamento->aumentaConta($conta->id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valorFormatado, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td class="valor">@if(!$lancamento->aumentaConta($conta->id)) {!! link_to_route('contas.lancamentos.edit', $lancamento->valorFormatado, ['conta' => $conta->id, 'lancamento' => $lancamento->id]) !!} @endif</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal($saldo) }}</td>
                        <td>
                            {!! Form::open(['route' => ['lancamentos.destroy', $lancamento->id], 'method' => 'DELETE', 'id' => "delete-form-$lancamento->id"]) !!}
                            {!! Form::hidden('contaId', $conta->id) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $lancamento->id }}"><i class="fa fa-trash-o"></i></button>
                            <a href="/contas/{{ $conta->id }}/lancamentos/duplicate/{{ $conta->id == $lancamento->conta_credito_id ? 'credito' : 'debito' }}/{{ $lancamento->id }}"
                               title="Duplicar"><i
                                        class="fa fa-copy"></i></a>
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
    @if($conta->id)
        <a href="/contas/{{ $conta->id }}/lancamentos/create/{{ $operacaoAumento }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo aumento</a>
        <a href="/contas/{{ $conta->id }}/lancamentos/create/{{ $operacaoReducao }}" class="btn btn-success"><i class="fa fa-plus"></i> Nova redu&ccedil;&atilde;o</a>
        <a href="/contas/{{ $conta->id }}/reconciliar" class="btn btn-success"><i class="fa fa-check"></i> Reconciliar</a>
    @endif
@stop