<?php

namespace App;

use App\Services\DateHelper;
use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            $contaAPagar->atualizarLancamentosFuturos();
        });

        ContaAPagar::updated(function ($contaAPagar) {
            $contaAPagar->atualizarLancamentosFuturos();
        });

        ContaAPagar::deleting(function ($contaAPagar) {
            DB::table('lancamentos_futuros')
                ->where('conta_a_pagar_id', $contaAPagar->id)
                ->delete();
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

    public function periodicidade()
    {
        return $this->belongsTo('App\Periodicidade');
    }

    public function lancamentosFuturos()
    {
        return $this->hasMany('App\LancamentoFuturo');
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

    public function getParcelaFormatadaAttribute()
    {
        return sprintf('%02d', $this->parcela_atual) . '/' . sprintf('%02d', $this->parcela_total);
    }

    public function atualizarLancamentosFuturos()
    {
        DB::table('lancamentos_futuros')
            ->where('conta_a_pagar_id', $this->id)
            ->delete();

        $numeroParcelas = $this->parcela_total - $this->parcela_atual + 1;

        for ($i = 0; $i < $numeroParcelas; $i++) {
            $metodo = 'add' . $this->periodicidade->intervalo_unidade;
            $data = $this->data_proxima->copy()->$metodo($i * $this->periodicidade->intervalo_quantidade);

            $lancamentoFuturo = new LancamentoFuturo();
            $lancamentoFuturo->fill([
                'favorecido_id' => $this->favorecido_id,
                'conta_credito_id' => $this->conta_credito_id,
                'conta_debito_id' => $this->conta_debito_id,
                'documento' => $this->documento,
                'memorando' => $this->memorando,
                'valor' => $this->valor,
                'data' => $data,
                'conta_a_pagar_id' => $this->id,
                'parcela_atual' => $this->parcela_atual + $i,
                'parcela_total' => $this->parcela_total,
            ]);
            $lancamentoFuturo->save();
        }
    }
}
