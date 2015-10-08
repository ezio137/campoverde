<fieldset>
    <legend>Conta</legend>

    @include('layouts.forms.label', ['modelo' => $conta, 'atributo' => 'codigo_completo', 'label' => 'Código Completo', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.text', ['atributo' => 'codigo', 'label' => 'Código', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.select', ['atributo' => 'conta_pai_id', 'label' => 'Conta Pai', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])

    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            {!! link_to_route('contas_contabil.index', 'Cancelar', [], ['class' => 'btn btn-danger']) !!}
        </div>
    </div>
</fieldset>

@section('custom_scripts')
    <script type="application/javascript">
        $(function () {
            $('#conta_pai_id').select2();
        });
    </script>
@stop