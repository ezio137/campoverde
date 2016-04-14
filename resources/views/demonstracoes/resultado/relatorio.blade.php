@inject('numberHelper', 'App\Services\NumberHelper')
@inject('dateHelper', 'App\Services\DateHelper')

<html>
<head>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="row">
                    <h2 class="text-center">Resultado</h2>
                </div>
                <div class="row" id="conteudo-demonstracao">
                    @include('demonstracoes.resultado.partials.dados')
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
