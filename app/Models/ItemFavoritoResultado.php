<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemFavoritoResultado extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $table = 'itens_favorito_dre';
    protected $fillable = ['favorito_dre_id', 'conta_codigo_completo'];
}
