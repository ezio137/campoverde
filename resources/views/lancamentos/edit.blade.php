@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($lancamento, ['route' => ['contas.lancamentos.update', 'conta' => $conta->id, 'lancamento' => $lancamento->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'files' => true]) !!}
                    @include('lancamentos.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop