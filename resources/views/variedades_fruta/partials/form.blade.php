<div class="box-body">
    @include('layouts.forms.select', ['atributo' => 'fruta_id', 'label' => 'Fruta', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $frutasOptions])
    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            <a href="/variedades_fruta" class="btn btn-danger"><i class="fa fa-reply"></i> Cancelar</a>
        </div>
    </div>
</div>