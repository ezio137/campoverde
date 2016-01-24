@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="box ui-draggable ui-droppable">
                <div class="box-header">
                    <div class="box-name"></div>
                    <div class="box-icons"></div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    {!! Form::open(['route' => 'favoritos_balanco_patrimonial.store', 'class' => 'form-horizontal']) !!}
                    @include('favoritos_balanco_patrimonial.partials.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop