@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($variedadeFruta, ['route' => ['variedades_fruta.update', $variedadeFruta->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                @include('variedades_fruta.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop