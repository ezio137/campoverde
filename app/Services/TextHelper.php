<?php namespace App\Services;

class TextHelper
{
    public static function exibirTexto($value)
    {
        return preg_replace('/\n/', '<br/>', $value);
    }

    public static function exibirTipoLancamento($value)
    {
        switch($value) {
            case 'credito':
                return 'Crédito';
            case 'debito':
                return 'Débito';
            default:
                return '';
        }
    }
}