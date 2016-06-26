<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'nome', 'label' => 'Nome', 'larguraAtributo' => 5, 'larguraLabel' => 2])


    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
            @foreach($contas as $conta)
                {{ $conta->codigo_completo . ' ' . $conta->nome }}<br/>
            @endforeach
        </div>
    </div>

    <div class="box-footer">
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>