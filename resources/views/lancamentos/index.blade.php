@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/lancamentos/create" class="btn btn-primary"><i class="fa fa-plus"></i> Novo lan&ccedil;amento</a>
        </div>
    </div>

    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Data</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lancamentos as $lancamento)
                    <tr>
                        <td>{!! link_to_route('favorecidos.edit', $lancamento->data, ['id' => $lancamento->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['favorecidos.destroy', $lancamento->id], 'method' => 'DELETE', 'id' => "delete-form-$lancamento->id"]) !!}
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