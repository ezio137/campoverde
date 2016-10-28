@inject('numberHelper', 'App\Services\NumberHelper')
@inject('dateHelper', 'App\Services\DateHelper')


<div class="{{ $media == 'print' ? 'col-xs-6' : 'col-xs-12 col-sm-6' }}">
    <div class="row">
        <div class="col-xs-12">
            <table class="{{ $media == 'print' ? 'table-relatorio' : '' }}">
                <thead>
                </thead>
                <tbody>
                <tr>
                    <th></th>
                    <th>Quantidade</th>
                    <th>Peso (kg)</th>
                    <th>Total (R$)</th>
                    <th>R$/cx</th>
                    <th>R$/kg</th>
                </tr>
                @foreach($resultadoSubTotais as $result)
                    <tr>
                        <td>{{ isset($result) ? $result->groupBy : '' }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->quantidade : 0.0) }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->peso : 0.0) }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco : 0.0) }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco / $result->quantidade : 0.0) }}</td>
                        <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? ($result->peso > 0 ? $result->preco / $result->peso : 0.0) : 0.0) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <?php $result = $resultadoTotais->first() ?>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->quantidade : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->peso : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco / $result->quantidade : 0.0) }}</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->preco / $result->peso : 0.0) }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>