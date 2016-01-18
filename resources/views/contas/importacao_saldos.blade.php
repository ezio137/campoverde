@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box ui-draggable ui-droppable">
                <div class="box-header">
                    <div class="box-name"></div>
                    <div class="box-icons"></div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    {!! Form::open(['url' => '/contas/importacao_saldos', 'class' => 'form-horizontal', 'files' => 'true']) !!}
                    <div class="form-group">
                        {!! Form::label('arquivo', 'Arquivo', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::file('arquivo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-3">
                            {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop