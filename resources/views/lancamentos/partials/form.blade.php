<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'data_formatada', 'label' => 'Data', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'valor_formatado', 'label' => 'Valor', 'larguraAtributo' => 3, 'larguraLabel' => 2])
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

    @include('layouts.forms.text', ['atributo' => 'parcela_atual', 'label' => 'Parcela atual', 'larguraAtributo' => 3, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'parcela_total', 'label' => 'Total de parcelas', 'larguraAtributo' => 3, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            <a href="/contas/{{ $conta->id }}/lancamentos" class="btn btn-danger"><i class="fa fa-reply"></i>
                Cancelar</a>
        </div>
    </div>
</div>

@section('custom_scripts')
    <script type="application/javascript">
        $(function(){
            $('#data_formatada').datepicker({
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