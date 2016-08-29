<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEmbalagem extends Model
{
    protected $table = 'tipos_embalagem';

    protected $fillable = ['nome', 'peso', 'material_embalagem_id', 'classificacao_fruta_id'];
}