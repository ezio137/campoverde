@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/favorecidos/create" class="btn btn-success"><i class="fa fa-plus"></i> Novo favorecido</a>
        </div>
    </div>

    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($favorecidos as $favorecido)
                    <tr>
                        <td>{!! link_to_route('favorecidos.edit', $favorecido->nome, ['id' => $favorecido->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['favorecidos.destroy', $favorecido->id], 'method' => 'DELETE', 'id' => "delete-form-$favorecido->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $favorecido->id }}"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop