<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariedadeFruta extends Model
{
    public static $rules = [];
    protected $table = 'variedades_fruta';
    protected $fillable = ['nome', 'fruta_id'];

    public function fruta()
    {
        return $this->belongsTo('App\Fruta');
    }

    public static function options()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
