@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/tipos_embalagem/create" class="btn btn-success"><i class="fa fa-plus"></i> Novo tipo</a>
        </div>
    </div>

    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Material</th>
                    <th>Classificação</th>
                    <th>Peso</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tiposEmbalagem as $tipo)
                    <tr>
                        <td>{!! link_to_route('tipos_embalagem.edit', $tipo->nome, ['id' => $tipo->id]) !!}</td>
                        <td>{!! link_to_route('tipos_embalagem.edit', $tipo->materialEmbalagem ? $tipo->materialEmbalagem->nome : '', ['id' => $tipo->id]) !!}</td>
                        <td>{!! link_to_route('tipos_embalagem.edit', $tipo->classificacaoFruta ? $tipo->classificacaoFruta->nome : '', ['id' => $tipo->id]) !!}</td>
                        <td>{!! link_to_route('tipos_embalagem.edit', $tipo->peso_formatado, ['id' => $tipo->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['tipos_embalagem.destroy', $tipo->id], 'method' => 'DELETE', 'id' => "delete-form-$tipo->id"]) !!}
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