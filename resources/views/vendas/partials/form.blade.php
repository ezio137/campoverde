<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'data_venda_formatada', 'label' => 'Data', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.select', ['atributo' => 'cliente_id', 'label' => 'Cliente', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $clientesOptions])
    @include('layouts.forms.text', ['atributo' => 'periodo', 'label' => 'Período', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.checkbox', ['atributo' => 'ind_quitado', 'label' => 'Quitado', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'data_vencimento_formatada', 'label' => 'Data Vencimento', 'larguraAtributo' => 5, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            <a href="/vendas" class="btn btn-danger"><i class="fa fa-reply"></i> Cancelar</a>
        </div>
    </div>
</div>

@section('custom_scripts')
    <script>
        $(function () {
            $('#data_venda_formatada').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('#data_vencimento_formatada').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('#cliente_id').select2({
                tags: true
            });
        });
    </script>
@stop