@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($favorecido, ['route' => ['favorecidos.update', $favorecido->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                    @include('favorecidos.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop