<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodicidade extends Model
{
    protected $fillable = ['nome', 'intervalo_quantidade', 'intervalo_unidade', 'ind_mesmo_dia', 'ordem'];

    public static function periodicidadesOptions()
    {
        return static::orderBy('ordem')->pluck('nome', 'id');
    }
}
