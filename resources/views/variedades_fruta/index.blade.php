@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/variedades_fruta/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova variedade</a>
        </div>
    </div>

    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Fruta</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($variedadesFruta as $variedade)
                    <tr>
                        <td>{!! link_to_route('variedades_fruta.edit', $variedade->nome, ['id' => $variedade->id]) !!}</td>
                        <td>{!! link_to_route('variedades_fruta.edit', $variedade->fruta->nome, ['id' => $variedade->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['variedades_fruta.destroy', $variedade->id], 'method' => 'DELETE', 'id' => "delete-form-$variedade->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $variedade->id }}"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop