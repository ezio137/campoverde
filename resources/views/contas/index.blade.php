@inject('numberHelper', 'App\Services\NumberHelper')

@extends('layouts.master')

@section('content')
    <div id="lista-contas">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-condensed table-striped small">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Saldo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contas as $conta)
                        <tr>
                            <td>
                                <a class="anchor" id="conta-{{ $conta->codigo_completo }}"></a>
                                {!! link_to_route('contas.lancamentos', $conta->codigo_completo, ['id' => $conta->id]) !!}
                            </td>
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

@section('botoes-footer')
    <a href="/contas/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova conta</a>&emsp;
    <span>Atalhos: </span>&emsp;
    <a href="#conta-1" class="h3">1</a>&emsp;
    <a href="#conta-2" class="h3">2</a>&emsp;
    <a href="#conta-3" class="h3">3</a>&emsp;
    <a href="#conta-4" class="h3">4</a>&emsp;
    <a href="#conta-5" class="h3">5</a>&emsp;
    <a href="#conta-6" class="h3">6</a>&emsp;
    {{--<a href="/contas/importacao" class="btn btn-success"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o--}}
        {{--Contas</a>--}}
    {{--<a href="/contas/importacao_saldos" class="btn btn-success"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o--}}
        {{--Saldos</a>--}}
@stop