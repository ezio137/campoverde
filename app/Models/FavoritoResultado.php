<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoritoResultado extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $table = 'favoritos_dre';
    protected $fillable = ['nome'];

    public function itens()
    {
        return $this->hasMany('App\ItemFavoritoResultado', 'favorito_dre_id');
    }
}
