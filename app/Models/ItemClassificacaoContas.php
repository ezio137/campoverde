<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemClassificacaoContas extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'itens_classificacao_contas';
    protected $fillable = ['classificacao_contas_id', 'nome'];
}
