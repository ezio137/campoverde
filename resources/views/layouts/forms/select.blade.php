<?php
if (!isset($larguraLabel)) {
    $larguraLabel = 3;
}
if (!isset($larguraAtributo)) {
    $larguraAtributo = 3;
}
if (!isset($valorPadrao)) {
    $valorPadrao = null;
}
if (!isset($classe)) {
    $classe = '';
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

<div class="{{ $formGroup }} {{ $errors->has($atributo) ? 'has-error' : '' }}">
    {!! Form::label($atributo, $label, ['class' => "col-sm-$larguraLabel control-label $required"]) !!}
    <div class="col-sm-{{ $larguraAtributo }}">
        {!! Form::select($atributo, $options, $valorPadrao, ['class' => "form-control $classe"]) !!}
    </div>
    {!! $errors->first($atributo, "<small class=\"help-block col-sm-offset-$larguraLabel col-sm-$larguraMensagemErro\" style=\"\">:message</small>") !!}
</div>