@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::model($tipoEmbalagem, ['route' => ['tipos_embalagem.update', $tipoEmbalagem->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                @include('tipos_embalagem.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop