<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Lancamento extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['favorecido_id', 'documento', 'valor', 'data', 'memorando', 'conta_credito_id', 'conta_debito_id'];

    public function contaCredito()
    {
        return $this->belongsTo('App\Conta', 'conta_credito_id');
    }

    public function contaDebito()
    {
        return $this->belongsTo('App\Conta', 'conta_debito_id');
    }
}
