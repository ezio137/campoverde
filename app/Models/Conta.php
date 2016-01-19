<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Conta extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['codigo', 'nome', 'codigo_completo', 'conta_pai_id', 'saldo'];

    public static function boot()
    {
        parent::boot();

        Conta::saving(function ($conta) {
            $conta->codigo_completo = ($conta->contaPai ? $conta->contaPai->codigo_completo . '.' : '') . $conta->codigo;
            $listaCodigoCompleto = explode('.', $conta->codigo_completo);
            $listaCodigoCompleto = array_map(function ($x) {
                return str_pad($x, 3, '0', STR_PAD_LEFT);
            }, $listaCodigoCompleto);
            $conta->codigo_completo_ordenavel = implode('.', $listaCodigoCompleto);
        });
    }

    public static function contasOptions($contaAtualId = 0)
    {
        $contas = self::select('id', DB::raw('concat(codigo_completo, " ", nome) as nome'))->where('id', '<>', $contaAtualId)->orderBy('codigo_completo_ordenavel')->pluck('nome', 'id');
        return $contas->all();
    }

    public static function contasOptionsNenhum($contaAtualId = 0)
    {
        $contaInicial = [0 => 'Nenhum'];
        $contas = self::contasOptions($contaAtualId);
        return $contaInicial + $contas;
    }

    public function contaPai()
    {
        return $this->belongsTo('App\Conta', 'conta_pai_id');
    }

    public function nivel()
    {
        return sizeof(explode('.', $this->codigo_completo));
    }

    public function getCodigoNomeAttribute()
    {
        return "$this->codigo_completo $this->nome";
    }

    public function getAumentaComDebitoAttribute()
    {
        return starts_with($this->codigo_completo, '1') || starts_with($this->codigo_completo, '5');
    }

    public function getAumentaComCreditoAttribute()
    {
        return starts_with($this->codigo_completo, '2') || starts_with($this->codigo_completo, '3') || starts_with($this->codigo_completo, '4');
    }
}
