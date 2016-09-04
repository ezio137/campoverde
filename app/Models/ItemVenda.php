<?php

namespace App;

use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $table = 'itens_venda';

    protected $fillable = [
        'venda_id',
        'variedade_fruta_id',
        'tipo_embalagem_id',
        'quantidade',
        'quantidade_formatada',
        'preco',
        'preco_formatado',
    ];

    protected $appends = [
        'quantidade_formatada',
        'preco_formatado',
    ];

    public function getValorTotalAttribute()
    {
        return $this->quantidade * $this->preco;
    }

    public function VariedadeFruta()
    {
        return $this->belongsTo('App\VariedadeFruta');
    }

    public function TipoEmbalagem()
    {
        return $this->belongsTo('App\TipoEmbalagem');
    }

    public function getQuantidadeFormatadaAttribute()
    {
        return NumberHelper::exibirDecimal($this->quantidade);
    }

    public function setQuantidadeFormatadaAttribute($value)
    {
        $this->attributes['quantidade'] = NumberHelper::extrairDecimal($value);
    }

    public function getPrecoFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->preco);
    }

    public function setPrecoFormatadoAttribute($value)
    {
        $this->attributes['preco'] = NumberHelper::extrairDecimal($value);
    }

    public function getValorTotalFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->valorTotal);
    }
}
