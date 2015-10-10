<?php namespace App\Services;

class NumberHelper
{
    public static function extrairDecimal($valor)
    {
        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public static function exibirDecimal($valor, $casas = 2)
    {
        return number_format($valor, $casas, ',', '.');
    }
}