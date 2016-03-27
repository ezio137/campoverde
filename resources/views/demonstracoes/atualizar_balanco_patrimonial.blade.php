@inject('numberHelper', 'App\Services\NumberHelper')
@inject('dateHelper', 'App\Services\DateHelper')


<div class="col-xs-12 col-sm-6">
    <div class="row">
        <div class="col-xs-12">
            <table>
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
                    <th>Ativo</th>
                </tr>
                @foreach($contasAtivo as $conta)
                    <tr class="contas">
                        <td style="padding-left: {{ $conta->nivel() * 10 }}px">{{ $conta->nome }} <i class="fa fa-close red hidden" data-id="{{ $conta->id }}"></i></td>
                        @foreach($meses as $mes)
                            <?php $result = $resultado->where('conta_id', $conta->id)->where('data_id', $mes->id)->first() ?>
                            <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total do Ativo</th>
                    @foreach($meses as $mes)
                        <?php $result = $resultadoTotais->where('tipo_conta', '1')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</th>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-6">
    <div class="row">
        <div class="col-xs-12">
            <table>
                <thead>
                <tr class="meses">
                    <th>&nbsp;</th>
                    @foreach($meses as $mes)
                        <th>{{ $dateHelper::exibirDataMes($mes->data) }} <i class="fa fa-close red hidden"
                                                                            data-id="{{ $mes->id }}"></i></th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Passivo</th>
                </tr>
                @foreach($contasPassivo as $conta)
                    <tr class="contas">
                        <td style="padding-left: {{ $conta->nivel() * 10 }}px">{{ $conta->nome }} <i
                                    class="fa fa-close red hidden" data-id="{{ $conta->id }}"></i></td>
                        @foreach($meses as $mes)
                            <?php $result = $resultado->where('conta_id', $conta->id)->where('data_id', $mes->id)->first() ?>
                            <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total do Passivo</th>
                    @foreach($meses as $mes)
                        <?php $result = $resultadoTotais->where('tipo_conta', '2')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <th>Patrim&ocirc;nio L&iacute;quido</th>
                </tr>
                @foreach($contasPL as $conta)
                    <tr class="contas">
                        <td style="padding-left: {{ $conta->nivel() * 10 }}px">{{ $conta->nome }} <i
                                    class="fa fa-close red hidden" data-id="{{ $conta->id }}"></i></td>
                        @foreach($meses as $mes)
                            <?php $result = $resultado->where('conta_id', $conta->id)->where('data_id', $mes->id)->first() ?>
                            <td class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <td style="padding-left: 10px">Lucros/Preju&iacute;zos</td>
                    @foreach($meses as $mes)
                        <?php $resultAtivo = $resultadoTotais->where('tipo_conta', '1')->where('data_id', $mes->id)->first() ?>
                        <?php $resultPassivo = $resultadoTotais->where('tipo_conta', '2')->where('data_id', $mes->id)->first() ?>
                        <?php $resultPL = $resultadoTotais->where('tipo_conta', '3')->where('data_id', $mes->id)->first() ?>
                        <td class="valor">{{ $numberHelper::exibirDecimal((isset($resultAtivo) ? $resultAtivo->saldo : 0.0) - (isset($resultPassivo) ? $resultPassivo->saldo : 0.0) - (isset($resultPL) ? $resultPL->saldo : 0.0)) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Total do PL</th>
                    @foreach($meses as $mes)
                        <?php $resultAtivo = $resultadoTotais->where('tipo_conta', '1')->where('data_id', $mes->id)->first() ?>
                        <?php $resultPassivo = $resultadoTotais->where('tipo_conta', '2')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal((isset($resultAtivo) ? $resultAtivo->saldo : 0.0) - (isset($resultPassivo) ? $resultPassivo->saldo : 0.0)) }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <th>Total do Passivo + PL</th>
                    @foreach($meses as $mes)
                        <?php $result = $resultadoTotais->where('tipo_conta', '1')->where('data_id', $mes->id)->first() ?>
                        <th class="valor">{{ $numberHelper::exibirDecimal(isset($result) ? $result->saldo : 0.0) }}</th>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>