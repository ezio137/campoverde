<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemFavoritoBalancoPatrimonial extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $table = 'itens_favorito_bp';
    protected $fillable = ['favorito_bp_id', 'conta_codigo_completo'];
}
