<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorecido extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['nome'];

    public static function favorecidosOptions()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
