@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box box-success">
                {!! Form::open(['route' => ['contas.lancamentos.store', $conta->id], 'class' => 'form-horizontal']) !!}
                    @include('lancamentos.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop