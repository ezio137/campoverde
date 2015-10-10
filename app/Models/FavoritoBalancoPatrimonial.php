<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoritoBalancoPatrimonial extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $table = 'favoritos_bp';
    protected $fillable = ['nome'];

    public function itens()
    {
        return $this->hasMany('App\ItemFavoritoBalancoPatrimonial', 'favorito_bp_id');
    }
}
