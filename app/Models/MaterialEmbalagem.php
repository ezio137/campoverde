<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialEmbalagem extends Model
{
    protected $table = 'materiais_embalagem';

    protected $fillable = ['nome', 'descricao'];
}
