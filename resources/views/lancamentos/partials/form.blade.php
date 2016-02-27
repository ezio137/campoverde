<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'data', 'label' => 'Data', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'valor', 'label' => 'Valor', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.select', ['atributo' => 'favorecido_id', 'label' => 'Favorecido', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $favorecidosOptions])
    @if($tipo == 'credito')
        @include('layouts.forms.select', ['atributo' => 'conta_debito_id', 'label' => 'Conta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
        <input type="hidden" name="conta_credito_id" value="{{ $conta->id }}">
    @endif
    @if($tipo == 'debito')
        @include('layouts.forms.select', ['atributo' => 'conta_credito_id', 'label' => 'Conta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
        <input type="hidden" name="conta_debito_id" value="{{ $conta->id }}">
    @endif
    @include('layouts.forms.text', ['atributo' => 'memorando', 'label' => 'Memorando', 'larguraAtributo' => 8, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'documento', 'label' => 'Documento', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.file', ['atributo' => 'anexo', 'label' => 'Anexo', 'larguraAtributo' => 3, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            {!! link_to_route('contas.lancamentos', 'Cancelar', ['conta' => $conta->id], ['class' => 'btn btn-danger']) !!}
        </div>
    </div>
</div>

@section('custom_scripts')
    <script type="application/javascript">
        $(function(){
            $('#data').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('#favorecido_id').select2({
                tags: true
            });
            $('#conta_id').select2();
        });
    </script>
@stop