@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/contas_contabil/create" class="btn btn-primary"><i class="fa fa-plus"></i> Nova conta</a>
            <a href="/contas_contabil/importacao" class="btn btn-primary"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>C&oacute;digo</th>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($contas as $conta)
                    <tr>
                        <td>{!! link_to_route('contas_contabil.edit', $conta->codigo_completo, ['id' => $conta->id]) !!}</td>
                        <td>{!! link_to_route('contas_contabil.edit', $conta->nome, ['id' => $conta->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['contas_contabil.destroy', $conta->id], 'method' => 'DELETE', 'id' => "delete-form-$conta->id"]) !!}
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
@stop