<?php

namespace App;

use App\Services\DateHelper;
use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = [
        'favorecido_id',
        'documento',
        'valor',
        'data',
        'data_formatada',
        'memorando',
        'conta_credito_id',
        'conta_debito_id',
        'reconciliado',
        'valor_formatado',
        'parcela_atual',
        'parcela_total',
    ];
    protected $dates = ['deleted_at', 'data'];

    public static function boot()
    {
        parent::boot();

        Lancamento::created(function($lancamento){
            $contaCredito = $lancamento->contaCredito;
            $contaDebito = $lancamento->contaDebito;

            $contaCredito->aumentaComCredito
                ? $contaCredito->update(['saldo' => $contaCredito->saldo + $lancamento->valor])
                : $contaCredito->update(['saldo' => $contaCredito->saldo - $lancamento->valor]);
            $contaDebito->aumentaComDebito
                ? $contaDebito->update(['saldo' => $contaDebito->saldo + $lancamento->valor])
                : $contaDebito->update(['saldo' => $contaDebito->saldo - $lancamento->valor]);

        });

        Lancamento::deleting(function($lancamento){
            $contaCredito = $lancamento->contaCredito;
            $contaDebito = $lancamento->contaDebito;

            $contaCredito->aumentaComCredito
                ? $contaCredito->update(['saldo' => $contaCredito->saldo - $lancamento->valor])
                : $contaCredito->update(['saldo' => $contaCredito->saldo + $lancamento->valor]);
            $contaDebito->aumentaComDebito
                ? $contaDebito->update(['saldo' => $contaDebito->saldo - $lancamento->valor])
                : $contaDebito->update(['saldo' => $contaDebito->saldo + $lancamento->valor]);

        });

        Lancamento::updating(function($lancamento){
            $original = $lancamento->getOriginal();
            $valorAntigo = $original['valor'];
            $contaCreditoAntiga = Conta::find($original['conta_credito_id']);
            $contaDebitoAntiga = Conta::find($original['conta_debito_id']);

            $contaCreditoAntiga->aumentaComCredito
                ? $contaCreditoAntiga->update(['saldo' => $contaCreditoAntiga->saldo - $valorAntigo])
                : $contaCreditoAntiga->update(['saldo' => $contaCreditoAntiga->saldo + $valorAntigo]);
            $contaDebitoAntiga->aumentaComDebito
                ? $contaDebitoAntiga->update(['saldo' => $contaDebitoAntiga->saldo - $valorAntigo])
                : $contaDebitoAntiga->update(['saldo' => $contaDebitoAntiga->saldo + $valorAntigo]);

            $contaCredito = Conta::find($lancamento->conta_credito_id);
            $contaDebito = Conta::find($lancamento->conta_debito_id);

            $contaCredito->aumentaComCredito
                ? $contaCredito->update(['saldo' => $contaCredito->saldo + $lancamento->valor])
                : $contaCredito->update(['saldo' => $contaCredito->saldo - $lancamento->valor]);
            $contaDebito->aumentaComDebito
                ? $contaDebito->update(['saldo' => $contaDebito->saldo + $lancamento->valor])
                : $contaDebito->update(['saldo' => $contaDebito->saldo - $lancamento->valor]);

        });
    }

    public function contaDebito()
    {
        return $this->belongsTo('App\Conta', 'conta_debito_id');
    }

    public function favorecido()
    {
        return $this->belongsTo('App\Favorecido');
    }

    public function getDataFormatadaAttribute()
    {
        return DateHelper::exibirData($this->data);
    }

    public function setDataFormatadaAttribute($value)
    {
        $this->attributes['data'] = DateHelper::extrairData($value);
    }

    public function getValorFormatadoAttribute()
    {
        return number_format($this->attributes['valor'], 2, ',', '.');
    }

    public function setValorFormatadoAttribute($value)
    {
        $this->attributes['valor'] = NumberHelper::extrairDecimal($value);
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

    public function contaCredito()
    {
        return $this->belongsTo('App\Conta', 'conta_credito_id');
    }

    public function anexos()
    {
        return $this->morphMany('App\Anexo', 'anexavel');
    }

    public function getMemorandoAbreviadoAttribute()
    {
        $reticencias = strlen($this->memorando) > 30 ? '...' : '';
        return substr($this->memorando, 0, 30) . $reticencias;
    }
}
