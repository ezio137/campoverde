@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::open(['route' => 'contas_a_pagar.store', 'class' => 'form-horizontal', 'files' => true]) !!}
                @include('contas_a_pagar.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop