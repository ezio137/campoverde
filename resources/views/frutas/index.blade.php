@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/frutas/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova fruta</a>
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
                @foreach($frutas as $fruta)
                    <tr>
                        <td>{!! link_to_route('frutas.edit', $fruta->nome, ['id' => $fruta->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['frutas.destroy', $fruta->id], 'method' => 'DELETE', 'id' => "delete-form-$fruta->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $fruta->id }}"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop