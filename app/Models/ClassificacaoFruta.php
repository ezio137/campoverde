<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassificacaoFruta extends Model
{
    protected $table = 'classificacoes_fruta';

    protected $fillable = ['nome'];
}
