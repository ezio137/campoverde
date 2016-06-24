<?php

namespace App;

use App\Services\DateHelper;
use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class ContaAPagar extends Model
{
    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'favorecido_id',
        'conta_credito_id',
        'conta_debito_id',
        'periodicidade_id',
        'data_proxima',
        'data_proxima_formatada',
        'documento',
        'valor',
        'valor_formatado',
        'memorando',
        'parcela_atual',
        'parcela_total',
    ];

    protected $dates = ['data'];

    public static function boot()
    {
        parent::boot();

        ContaAPagar::created(function ($contaAPagar) {
            $lancamentoFuturo = new LancamentoFuturo();
            $lancamentoFuturo->fill(array_only($contaAPagar->toArray(),
                ['favorecido_id', 'conta_credito_id', 'conta_debito_id', 'data', 'documento', 'valor']
            ));
            $lancamentoFuturo->save();
        });
    }

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

    public function getDataProximaFormatadaAttribute()
    {
        return DateHelper::exibirData($this->data_proxima);
    }

    public function setDataProximaFormatadaAttribute($value)
    {
        $this->attributes['data_proxima'] = DateHelper::extrairData($value);
    }
}
