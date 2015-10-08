<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Conta extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $table = 'contas_contabil';
    protected $fillable = ['codigo', 'nome', 'codigo_completo', 'conta_pai_id'];

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
        $contaInicial = collect([0 => 'Nenhum']);
        $contas = self::select('id', DB::raw('concat(codigo_completo, " - ", nome) as codigoNome'))->where('id', '<>', $contaAtualId)->lists('codigoNome', 'id');
        return $contaInicial->all() + $contas->all();
    }

    public function contaPai()
    {
        return $this->belongsTo('App\Conta', 'conta_pai_id');
    }
}
