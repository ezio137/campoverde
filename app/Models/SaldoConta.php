<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaldoConta extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'saldos_conta_contabil';
    protected $fillable = ['conta_contabil_id', 'mes', 'saldo'];
}
