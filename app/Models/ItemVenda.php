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
        'preco',
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

    public function getPrecoFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->preco);
    }

    public function getValorTotalFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->valorTotal);
    }
}
