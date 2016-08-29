<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'cliente_id',
        'data_venda',
        'periodo',
        'ind_quitado',
        'data_vencimento',
    ];
}
