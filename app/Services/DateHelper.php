<?php namespace App\Services;

use Carbon\Carbon;

class DateHelper
{
    public static function exibirDataMes($value)
    {
        if ($value instanceof Carbon) {
            return $value->formatLocalized('%b-%y');
        } elseif ($value <> '') {
            $value = preg_replace('/\s.*/', '', $value);  // removendo informacoes de hora caso existam
            return Carbon::createFromFormat('Y-m-d', $value)->formatLocalized('%b-%y');
        } else {
            return null;
        }
    }

    public static function extrairData($value)
    {
        if ($value instanceof Carbon)
            return $value;
        elseif ($value <> '')
            return Carbon::createFromFormat('d/m/Y', $value);
        else
            return null;
    }

    public static function exibirData($value)
    {
        if ($value instanceof Carbon) {
            return $value->format('d/m/Y');
        } elseif ($value <> '') {
            $value = preg_replace('/\s.*/', '', $value);  // removendo informacoes de hora caso existam
            return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
        } else {
            return null;
        }
    }
}