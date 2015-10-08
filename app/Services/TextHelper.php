<?php namespace App\Services;

class TextHelper
{
    public static function exibirTexto($value)
    {
        return preg_replace('/\n/', '<br/>', $value);
    }
}