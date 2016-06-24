<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LancamentoFuturo extends Model
{
    protected $table = 'lancamentos_futuros';

    protected $fillable = [
        'favorecido_id',
        'documento',
        'valor',
        'data',
        'memorando',
        'conta_credito_id',
        'conta_debito_id',
        'reconciliado',
        'valor_formatado'
    ];
}
