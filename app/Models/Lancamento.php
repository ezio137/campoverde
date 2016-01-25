<?php

namespace App;

use App\Services\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Lancamento extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['favorecido_id', 'documento', 'valor', 'data', 'memorando', 'conta_credito_id', 'conta_debito_id'];
    protected $dates = ['deleted_at', 'data'];

    public function contaCredito()
    {
        return $this->belongsTo('App\Conta', 'conta_credito_id');
    }

    public function contaDebito()
    {
        return $this->belongsTo('App\Conta', 'conta_debito_id');
    }

    public function favorecido()
    {
        return $this->belongsTo('App\Favorecido');
    }

    public function getDataAttribute($value)
    {
        return DateHelper::exibirData($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = DateHelper::extrairData($value);
    }

    public function aumentaConta($contaId)
    {
        if ($this->contaCredito->id == $contaId && $this->contaCredito->aumentaComCredito) {
            return true;
        } elseif ($this->contaDebito->id == $contaId && $this->contaDebito->aumentaComDebito) {
            return true;
        } else {
            return false;
        }
    }

    public function saldoConta($tipo)
    {
        return $this->contaCredito()->saldo($this->data);
    }
}
