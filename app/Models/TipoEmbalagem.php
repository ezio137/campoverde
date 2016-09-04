<?php

namespace App;

use App\Services\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class TipoEmbalagem extends Model
{
    protected $table = 'tipos_embalagem';

    public static $rules = [];

    protected $fillable = ['nome', 'peso', 'peso_formatado', 'material_embalagem_id', 'classificacao_fruta_id', 'codigo_legado'];

    public static function options()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }

    public function materialEmbalagem()
    {
        return $this->belongsTo('App\MaterialEmbalagem');
    }

    public function classificacaoFruta()
    {
        return $this->belongsTo('App\ClassificacaoFruta');
    }

    public function getPesoFormatadoAttribute()
    {
        return NumberHelper::exibirDecimal($this->peso);
    }

    public function setPesoFormatadoAttribute($value)
    {
        $this->attributes['peso'] = NumberHelper::extrairDecimal($value);
    }
}
