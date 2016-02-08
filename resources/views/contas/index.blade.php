@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/contas/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova conta</a>
            <a href="/contas/importacao" class="btn btn-success"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o
                Contas</a>
            <a href="/contas/importacao_saldos" class="btn btn-success"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o
                Saldos</a>
        </div>
    </div>

    <div id="lista-contas">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-condensed table-striped small">
                    <thead>
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Nome</th>
                        <th>Saldo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contas as $conta)
                        <tr>
                            <td>{!! link_to_route('contas.lancamentos', $conta->codigo_completo, ['id' => $conta->id]) !!}</td>
                            <td style="padding-left: {{ $conta->nivel() * 10 }}px">{!! link_to_route('contas.lancamentos', $conta->nome, ['id' => $conta->id]) !!}</td>
                            <td class="valor">{!! link_to_route('contas.lancamentos', $numberHelper::exibirDecimal($conta->saldo), ['id' => $conta->id]) !!}</td>
                            <td>
                                {!! Form::open(['route' => ['contas.destroy', $conta->id], 'method' => 'DELETE', 'id' => "delete-form-$conta->id"]) !!}
                                <a href="/contas/{{ $conta->id }}/edit"><i class="fa fa-pencil"></i></a>
                                <button type="button" class="btn-link btn-delete-confirmation"
                                        data-delete-item-id="{{ $conta->id }}"><i class="fa fa-trash-o"></i></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop