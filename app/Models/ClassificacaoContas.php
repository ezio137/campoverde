<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassificacaoContas extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'classificacoes_contas';
    protected $fillable = ['nome'];
}
