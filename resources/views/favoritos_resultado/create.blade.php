@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::open(['route' => 'favoritos_resultado.store', 'class' => 'form-horizontal']) !!}
                @include('favoritos_resultado.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop