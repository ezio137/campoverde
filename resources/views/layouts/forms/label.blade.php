@inject('textHelper', 'App\Services\TextHelper')

<?php
if (!isset($modelo)) {
    $modelo = null;
}
if (!isset($valorPadrao)) {
    $valorPadrao = '';
}
if (!isset($larguraLabel)) {
    $larguraLabel = 3;
}
if (!isset($larguraAtributo)) {
    $larguraAtributo = 3;
}
if (!isset($required) || $required = false) {
    $required = '';
} else {
    $required = 'required';
}
if (!isset($inline) || $inline = false) {
    $formGroup = 'form-group';
} else {
    $formGroup = '';
}
$larguraMensagemErro = 12 - $larguraLabel;
?>

<div class="{{ $formGroup }}">
    {!! Form::label('', $label, ['class' => "col-sm-$larguraLabel control-label"]) !!}
    <div class="col-sm-{{ $larguraAtributo }}">
        <p class="form-control-static">{!! $modelo ? $textHelper::exibirTexto($modelo->$atributo) : $valorPadrao !!}</p>
    </div>
</div>