<div class="box-body">
    @include('layouts.forms.text', ['atributo' => 'data_venda_formatada', 'label' => 'Data', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.select', ['atributo' => 'cliente_id', 'label' => 'Cliente', 'larguraAtributo' => 5, 'larguraLabel' => 2, 'options' => $clientesOptions])
    @include('layouts.forms.text', ['atributo' => 'periodo', 'label' => 'Período', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.checkbox', ['atributo' => 'ind_quitado', 'label' => 'Quitado', 'larguraAtributo' => 5, 'larguraLabel' => 2])
    @include('layouts.forms.text', ['atributo' => 'data_vencimento_formatada', 'label' => 'Data Vencimento', 'larguraAtributo' => 5, 'larguraLabel' => 2])

    <div class="row">
        <table class="table table-hover" id="itens-venda">
            <thead>
                <tr>
                    <th>Variedade</th>
                    <th>Embalagem</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th class="text-right">Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in itens">
                    <td>
                        <select name="itens[@{{ $index }}][variedade_fruta_id]" v-model="item.variedade_fruta_id">
                            <option v-for="(key, value) in variedadesOptions | orderBy 'value'" value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </td>
                    <td>
                        <select name="itens[@{{ $index }}][tipo_embalagem_id]" v-model="item.tipo_embalagem_id">
                            <option v-for="(key, value) in embalagensOptions | orderBy 'value'" value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="itens[@{{ $index }}][quantidade_formatada]" v-model="item.quantidade_formatada" class="text-right" />
                    </td>
                    <td>
                        <input type="text" name="itens[@{{ $index }}][preco_formatado]" v-model="item.preco_formatado" class="text-right" />
                    </td>
                    <td class="text-right">@{{ valor_total_formatado(item) }}</td>
                    <td><button type="button" class="btn-link" @click="itens.$remove(item)"><i class="fa fa-trash-o"></i></button></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>@{{ valor_total_venda_formatado }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2">
                        <button type="button" class="btn btn-primary" @click="adicionar_item()"><i class="fa fa-plus"></i> Adicionar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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

        new Vue({
            el: '#itens-venda',
            data: {
                itens: {!! isset($venda) ? $venda->itens->toJson() : collect()->toJson() !!},
                variedadesOptions: {!! $variedadesOptions->toJson() !!},
                embalagensOptions: {!! $embalagensOptions->toJson() !!}
            },
            computed: {
                valor_total_venda: function() {
                    return this.itens.reduce(function(total, item) {
                        return total + item.quantidade * item.preco;
                    }, 0);
                },
                valor_total_venda_formatado: function() {
                    return this.valor_total_venda.toFixed(2);
                }
            },
            methods: {
                valor_total: function(item) {
                    item.quantidade = parseFloat(item.quantidade_formatada.replace(",", "."));
                    item.preco = parseFloat(item.preco_formatado.replace(",", "."));
                    return item.quantidade * item.preco;
                },
                valor_total_formatado: function(item) {
                    return this.valor_total(item).toFixed(2);
                },
                aplicar_select2: function() {
                    $('#itens-venda select').not('.select2-hidden-accessible').select2();
                },
                adicionar_item: function() {
                    this.itens.push({
                        'quantidade': 0,
                        'quantidade_formatada': 0,
                        'preco': 0,
                        'preco_formatado': 0
                    });
                }
            },
            watch: {
                itens: function() {
                    this.aplicar_select2();
                }
            },
            ready: function() {
                this.aplicar_select2();
            }
        });
    </script>
@stop