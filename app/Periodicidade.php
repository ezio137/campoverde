<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodicidade extends Model
{
    protected $fillable = ['nome', 'numero_dias', 'ind_mesmo_dia'];

    public static function periodicidadesOptions()
    {
        return static::orderBy('numero_dias')->pluck('nome', 'id');
    }
}
