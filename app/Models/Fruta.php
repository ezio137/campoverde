<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fruta extends Model
{
    public static $rules = [];
    protected $fillable = ['nome'];

    public static function frutasOptions()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
