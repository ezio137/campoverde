@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::open(['route' => 'variedades_fruta.store', 'class' => 'form-horizontal']) !!}
                @include('variedades_fruta.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop