<?php

namespace App;

use App\Services\DateHelper;
use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    public static $rules = [];

    protected $fillable = [
        'cliente_id',
        'data_venda',
        'data_venda_formatada',
        'periodo',
        'ind_quitado',
        'data_vencimento',
        'data_vencimento_formatada',
    ];

    protected $dates = [
        'data_venda',
        'data_vencimento',
    ];

    public static function boot()
    {
        parent::boot();

        Venda::deleting(function($venda) {
            $venda->itens->each(function($item) {
                $item->delete();
            });
        });
    }

    public function getDataVendaFormatadaAttribute()
    {
        return DateHelper::exibirData($this->data_venda);
    }

    public function setDataVendaFormatadaAttribute($value)
    {
        $this->attributes['data_venda'] = DateHelper::extrairData($value);
    }

    public function getDataVencimentoFormatadaAttribute()
    {
        return $this->data_vencimento == '0000-00-00' ? DateHelper::exibirData($this->data_vencimento) : '';
    }

    public function setDataVencimentoFormatadaAttribute($value)
    {
        $this->attributes['data_vencimento'] = DateHelper::extrairData($value);
    }

    public function getValorTotalAttribute()
    {
        return $this->itens->sum(function($item) {
            return $item->valorTotal;
        });
    }

    public function getValorTotalFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->valorTotal);
    }

    public function setIndQuitadoAttribute($value)
    {
        if ($value) {
            $this->attributes['ind_quitado'] = 1;
        } else {
            $this->attributes['ind_quitado'] = 0;
        }
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function itens()
    {
        return $this->hasMany('App\ItemVenda')->with(['variedadeFruta', 'tipoEmbalagem']);
    }
}
