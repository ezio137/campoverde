<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome'];

    public static function options()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
