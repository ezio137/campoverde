@inject('numberHelper', 'App\Services\NumberHelper')
@inject('dateHelper', 'App\Services\DateHelper')


<div class="{{ $media == 'print' ? 'col-xs-6' : 'col-xs-12 col-sm-6' }}">
    <div class="row">
        <div class="col-xs-12">
            <table class="{{ $media == 'print' ? 'table-relatorio' : 'table table-striped' }}">
                <thead>
                </thead>
                <tbody>
                <tr>
                    <th></th>
                    <th colspan="2" class="text-center">Quantidade</th>
                    <th colspan="2" class="text-center">Peso (kg)</th>
                    <th colspan="2" class="text-center">Total (R$)</th>
                    <th class="text-center">R$/cx</th>
                    <th class="text-center">R$/kg</th>
                </tr>
                <?php $resultTotal = $resultadoTotais->first() ?>
                @foreach($resultadoSubTotais as $result)
                    <tr>
                        <td>{{ isset($result) ? $result->groupBy : '' }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->quantidade : 0.0) }}</td>
                        <td class="valor small">({{ $numberHelper::exibirDecimal(isset($result) ? $result->quantidade * 100 / $resultTotal->quantidade : 0.0) }}%)</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->peso : 0.0) }}</td>
                        <td class="valor small">({{ $numberHelper::exibirDecimal(isset($result) ? $result->peso * 100 / $resultTotal->peso : 0.0) }}%)</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco : 0.0) }}</td>
                        <td class="valor small">({{ $numberHelper::exibirDecimal(isset($result) ? $result->preco * 100 / $resultTotal->preco : 0.0) }}%)</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco / $result->quantidade : 0.0) }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? ($result->peso > 0 ? $result->preco / $result->peso : 0.0) : 0.0) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <th class="valor" colspan="2">{{ $numberHelper::exibirDecimal(isset($resultTotal) ? $resultTotal->quantidade : 0.0) }}</th>
                    <th class="valor" colspan="2">{{ $numberHelper::exibirDecimal(isset($resultTotal) ? $resultTotal->peso : 0.0) }}</th>
                    <th class="valor" colspan="2">{{ $numberHelper::exibirDecimal(isset($resultTotal) ? $resultTotal->preco : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($resultTotal) ? $resultTotal->preco / $resultTotal->quantidade : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($resultTotal) ? $resultTotal->preco / $resultTotal->peso : 0.0) }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>