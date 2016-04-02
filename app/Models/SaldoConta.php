<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaldoConta extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'saldos_conta';
    protected $fillable = ['conta_id', 'data_id', 'saldo', 'hora_calculo'];
}
