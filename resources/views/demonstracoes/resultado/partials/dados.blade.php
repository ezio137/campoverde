@inject('numberHelper', 'App\Services\NumberHelper')
@inject('dateHelper', 'App\Services\DateHelper')


<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <table class="{{ $media == 'print' ? 'table-relatorio' : '' }}">
                <thead>
                <tr class="meses">
                    <th>&nbsp;</th>
                    @foreach($meses as $mes)
                        <th>{{ $dateHelper::exibirDataMes($mes->data) }} <i class="fa fa-close red hidden" data-id="{{ $mes->id }}"></i></th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Receita</th>
                </tr>
                @foreach($contasReceita as $conta)
                    <tr class="contas">
                        <td style="padding-left: {{ $conta->nivel() * 10 }}px">{{ $conta->nome }} <i class="fa fa-close red hidden" data-id="{{ $conta->id }}"></i></td>
                        @foreach($meses as $mes)
                            <?php $result = $resultado->where('conta_id', $conta->id)->where('data_id', $mes->id)->first() ?>
                            <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->resultado : 0.0) }}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total da Receita</th>
                    @foreach($meses as $mes)
                        <?php $result = $resultadoTotais->where('tipo_conta', '4')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->resultado : 0.0) }}</th>
                    @endforeach
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <th>Despesa</th>
                </tr>
                @foreach($contasDespesa as $conta)
                    <tr class="contas">
                        <td style="padding-left: {{ $conta->nivel() * 10 }}px">{{ $conta->nome }} <i
                                    class="fa fa-close red hidden" data-id="{{ $conta->id }}"></i></td>
                        @foreach($meses as $mes)
                            <?php $result = $resultado->where('conta_id', $conta->id)->where('data_id', $mes->id)->first() ?>
                            <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->resultado : 0.0) }}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total da Despesa</th>
                    @foreach($meses as $mes)
                        <?php $result = $resultadoTotais->where('tipo_conta', '5')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->resultado : 0.0) }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>