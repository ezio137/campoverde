<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PadraoClassificacaoContas extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'padroes_classificacao_contas';
    protected $fillable = ['item_classificacao_contas_id', 'padrao'];
}
