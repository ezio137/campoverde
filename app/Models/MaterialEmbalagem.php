<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialEmbalagem extends Model
{
    protected $table = 'materiais_embalagem';

    protected $fillable = ['nome', 'descricao'];

    public static function options()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
