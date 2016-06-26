@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($lancamentoFuturo, ['route' => ['lancamentos_futuros.registrar', $lancamentoFuturo->id], 'class' => 'form-horizontal', 'files' => true]) !!}
                @include('lancamentos_futuros.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop