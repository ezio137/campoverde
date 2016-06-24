<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'data_proxima_formatada', 'label' => 'Data próxima', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'valor_formatado', 'label' => 'Valor', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.select', ['atributo' => 'favorecido_id', 'label' => 'Favorecido', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $favorecidosOptions])
    @include('layouts.forms.select', ['atributo' => 'conta_credito_id', 'label' => 'Conta Origem', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
    @include('layouts.forms.select', ['atributo' => 'conta_debito_id', 'label' => 'Conta Destino', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
    @include('layouts.forms.select', ['atributo' => 'periodicidade_id', 'label' => 'Periodicidade', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $periodicidadesOptions])
    @include('layouts.forms.text', ['atributo' => 'memorando', 'label' => 'Memorando', 'larguraAtributo' => 8, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'documento', 'label' => 'Documento', 'larguraAtributo' => 3, 'larguraLabel' => 2])

    @if(isset($lancamento))
        <div class="form-group">
            {!! Form::label('anexos', 'Anexos', ['class' => "col-sm-2 control-label"]) !!}
            <div class="col-sm-8">
                @foreach($lancamento->anexos as $anexo)
                    {!! link_to_route('anexo.download', $anexo->nome_original, ['id' => $anexo->id]) !!} <br/>
                @endforeach
            </div>
        </div>
    @endif

    @include('layouts.forms.file', ['atributo' => 'anexo', 'label' => 'Novo Anexo', 'larguraAtributo' => 3, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            {!! link_to_route('contas_a_pagar.index', 'Cancelar', [], ['class' => 'btn btn-danger']) !!}
        </div>
    </div>
</div>

@section('custom_scripts')
    <script type="application/javascript">
        $(function () {
            $('#data').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('#favorecido_id').select2({
                tags: true
            });
            $('#conta_debito_id').select2();
            $('#conta_credito_id').select2();
        });
    </script>
@stop