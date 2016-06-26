<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anexo extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'lancamento_id', 'extensao', 'nome_original', 'tamanho_bytes', 'anexavel_type', 'anexavel_id'];

    public function anexavel()
    {
        return $this->morphTo();
    }
}
