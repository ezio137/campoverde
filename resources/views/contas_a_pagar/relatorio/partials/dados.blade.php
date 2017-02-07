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
                    <th class="text-center">Total (R$)</th>
                </tr>
                <tr>
                    <th>Total</th>
                    <th class="valor">{{ $numberHelper::exibirDecimal(isset($resultadoTotais) ? $resultadoTotais : 0.0) }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>