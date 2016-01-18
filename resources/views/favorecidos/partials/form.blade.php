<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            {!! link_to_route('favorecidos.index', 'Cancelar', [], ['class' => 'btn btn-danger']) !!}
        </div>
    </div>
</div>