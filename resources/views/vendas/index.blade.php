@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="/vendas/create" class="btn btn-success"><i class="fa fa-plus"></i> Nova venda</a>
        </div>
    </div>

    <div class="box">
        <div class="box-body table-responsive no-padding">
            {!! $vendas->render() !!}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($vendas as $venda)
                    <tr>
                        <td>{!! link_to_route('vendas.edit', $venda->dataVendaFormatada, ['id' => $venda->id]) !!}</td>
                        <td>{!! link_to_route('vendas.edit', $venda->cliente->nome, ['id' => $venda->id]) !!}</td>
                        <td>{!! link_to_route('vendas.edit', $venda->valorTotalFormatado, ['id' => $venda->id]) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['vendas.destroy', $venda->id], 'method' => 'DELETE', 'id' => "delete-form-$venda->id"]) !!}
                            <button type="button" class="btn-link btn-delete-confirmation"
                                    data-delete-item-id="{{ $venda->id }}"><i class="fa fa-trash-o"></i></button>
                            <a href="/vendas/duplicate/{{ $venda->id }}"
                               title="Duplicar"><i
                                        class="fa fa-copy"></i></a>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $vendas->render() !!}
        </div>
    </div>
@stop