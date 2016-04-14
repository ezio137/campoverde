<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoConta extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'resultados_conta';
    protected $fillable = ['conta_id', 'data_id', 'resultado', 'hora_calculo'];
}
