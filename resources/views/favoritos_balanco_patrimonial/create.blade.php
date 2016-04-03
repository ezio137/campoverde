@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::open(['route' => 'favoritos_balanco_patrimonial.store', 'class' => 'form-horizontal']) !!}
                @include('favoritos_balanco_patrimonial.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop