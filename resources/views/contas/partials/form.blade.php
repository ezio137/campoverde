<div class="box-body">
    @include('layouts.forms.label', ['modelo' => $conta, 'atributo' => 'codigo_completo', 'label' => 'Código Completo', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.text', ['atributo' => 'codigo', 'label' => 'Código', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    @include('layouts.forms.select', ['atributo' => 'conta_pai_id', 'label' => 'Conta Pai', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $contasOptions])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            <a href="/contas" class="btn btn-danger"><i class="fa fa-reply"></i> Cancelar</a>
        </div>
    </div>
</div>

@section('custom_scripts')
    <script type="application/javascript">
        $(function () {
            $('#conta_pai_id').select2();
        });
    </script>
@stop