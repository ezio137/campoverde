<?php
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

if (!isset($default)) {
    $default = null;
}
?>

<div class="{{ $formGroup }} {{ $errors->has($atributo) ? 'has-error' : '' }}">
    {!! Form::label($atributo, $label, ['class' => "col-sm-$larguraLabel control-label $required"]) !!}
    <div class="col-sm-{{ $larguraAtributo }}">
        {!! Form::text($atributo, $default, ['class' => 'form-control']) !!}
    </div>
    {!! $errors->first($atributo, "<small class=\"help-block col-sm-offset-$larguraLabel col-sm-$larguraMensagemErro\" style=\"\">:message</small>") !!}
</div>