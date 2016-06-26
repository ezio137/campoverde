<?php

namespace App;

use App\Services\DateHelper;
use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class LancamentoFuturo extends Model
{
    protected $table = 'lancamentos_futuros';

    protected $fillable = [
        'favorecido_id',
        'conta_a_pagar_id',
        'documento',
        'valor',
        'data',
        'memorando',
        'conta_credito_id',
        'conta_debito_id',
        'reconciliado',
        'valor_formatado',
        'parcela_atual',
        'parcela_total',
    ];

    protected $dates = ['data'];

    public function favorecido()
    {
        return $this->belongsTo('App\Favorecido');
    }

    public function contaCredito()
    {
        return $this->belongsTo('App\Conta', 'conta_credito_id');
    }

    public function contaDebito()
    {
        return $this->belongsTo('App\Conta', 'conta_debito_id');
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

    public function getValorFormatadoAttribute()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function setValorFormatadoAttribute($value)
    {
        $this->attributes['valor'] = NumberHelper::extrairDecimal($value);
    }

    public function getDataFormatadaAttribute()
    {
        return DateHelper::exibirData($this->data);
    }

    public function setDataFormatadaAttribute($value)
    {
        $this->attributes['data'] = DateHelper::extrairData($value);
    }

    public function getParcelaFormatadaAttribute()
    {
        return sprintf('%02d', $this->parcela_atual) . '/' . sprintf('%02d', $this->parcela_total);
    }

    public function anexos()
    {
        return $this->morphMany('App\Anexo', 'anexavel');
    }

    public function contaAPagar()
    {
        return $this->belongsTo('App\ContaAPagar');
    }
}
