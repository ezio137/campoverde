<?php

namespace App;

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
}
