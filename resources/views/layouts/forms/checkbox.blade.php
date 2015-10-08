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
$larguraMensagemErro = 12 - $larguraLabel;
?>

<div class="form-group {{ $errors->has($atributo) ? 'has-error' : '' }}">
    {!! Form::label($atributo, $label, ['class' => "col-sm-$larguraLabel control-label $required"]) !!}
    <div class="col-sm-{{ $larguraAtributo }}">
        {!! Form::hidden($atributo, false) !!}
        {!! Form::checkbox($atributo) !!}
    </div>
    {!! $errors->first($atributo, "<small class=\"help-block col-sm-offset-$larguraLabel col-sm-$larguraMensagemErro\" style=\"\">:message</small>") !!}
</div>