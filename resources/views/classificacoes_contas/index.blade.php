@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/classificacoes_contas/create" class="btn btn-primary"><i class="fa fa-plus"></i> Nova classifica&ccedil;&atilde;o</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tipos as $tipo)
                    <tr>
                        <td>{!! link_to_route('classificacoes_contas.edit', $tipo->nome, ['id' => $tipo->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['classificacoes_contas.destroy', $tipo->id], 'method' => 'DELETE', 'id' => "delete-form-$tipo->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $tipo->id }}"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop