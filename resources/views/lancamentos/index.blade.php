@injects('App\DateHelper', 'dateHelper')

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
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Favorecido</th>
                    <th>Conta</th>
                    <th>Aumento</th>
                    <th>Redu&ccedil;&atilde;o</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lancamentos as $lancamento)
                    <tr>
                        <td>{!! link_to_route('lancamentos.edit', $lancamento->data, ['id' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('lancamentos.edit', $lancamento->favorecido->nome, ['id' => $lancamento->id]) !!}</td>
                        <td>{!! link_to_route('lancamentos.edit', $conta->id == $lancamento->conta_credito_id ? $lancamento->contaDebito->codigoNome : $lancamento->contaCredito->codigoNome, ['id' => $lancamento->id]) !!}</td>
                        <td>@if($lancamento->aumentaConta($conta->id)) {!! link_to_route('lancamentos.edit', $lancamento->valor, ['id' => $lancamento->id]) !!} @endif</td>
                        <td>@if(!$lancamento->aumentaConta($conta->id)) {!! link_to_route('lancamentos.edit', $lancamento->valor, ['id' => $lancamento->id]) !!} @endif</td>
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