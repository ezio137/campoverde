<div class="box-body">
    @include('layouts.forms.select', ['atributo' => 'material_embalagem_id', 'label' => 'Material', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $materiaisOptions])
    @include('layouts.forms.select', ['atributo' => 'classificacao_fruta_id', 'label' => 'Classificação', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $classificacoesOptions])
    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'peso_formatado', 'label' => 'Peso', 'larguraAtributo' => 5, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            <a href="/tipos_embalagem" class="btn btn-danger"><i class="fa fa-reply"></i> Cancelar</a>
        </div>
    </div>
</div>