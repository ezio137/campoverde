@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($fruta, ['route' => ['frutas.update', $fruta->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                @include('frutas.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop