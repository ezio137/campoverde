<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LancamentoEfetivo extends Model
{
    protected $table = 'lancamentos_efetivos';

    protected $fillable = ['lancamento_id', 'data', 'conta_id', 'valor'];
}
