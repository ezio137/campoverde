@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($contaAPagar, ['route' => ['contas_a_pagar.update', $contaAPagar->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'files' => true]) !!}
                @include('contas_a_pagar.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop