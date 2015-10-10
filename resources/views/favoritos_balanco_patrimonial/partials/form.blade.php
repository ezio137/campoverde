<fieldset>
    <legend>Favorito</legend>

    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @foreach($contas as $conta)
        {{ $conta->codigo_completo . ' ' . $conta->nome }}<br/>
    @endforeach

    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</fieldset>