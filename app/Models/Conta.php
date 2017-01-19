<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Conta extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['codigo', 'nome', 'codigo_completo', 'conta_pai_id', 'saldo'];

    public static function boot()
    {
        parent::boot();

        Conta::saving(function ($conta) {
            if (!$conta->codigo) {
                $conta->codigo = Conta::where('conta_pai_id', $conta->conta_pai_id)->max('codigo') + 1;
            }

            $conta->codigo_completo = ($conta->contaPai ? $conta->contaPai->codigo_completo . '.' : '') . $conta->codigo;
            $listaCodigoCompleto = explode('.', $conta->codigo_completo);
            $listaCodigoCompleto = array_map(function ($x) {
                return str_pad($x, 3, '0', STR_PAD_LEFT);
            }, $listaCodigoCompleto);
            $conta->codigo_completo_ordenavel = implode('.', $listaCodigoCompleto);
        });

        Conta::deleting(function($conta) {
            $contasACorrigir = Conta::where('conta_pai_id', $conta->conta_pai_id)->where('codigo', '>', $conta->codigo)->get();
            foreach ($contasACorrigir as $contaACorrigir) {
                $contaACorrigir->codigo--;
                $contaACorrigir->save();
            }
        });

        Conta::updated(function($conta) {
            Log::info('update conta => '.$conta->nome);
            foreach ($conta->contasFilhas()->get() as $contaFilha) {
                Log::info('update conta filha => '.$contaFilha->nome);
                $contaFilha->updated_at = Carbon::now();
                $contaFilha->save();
            }
        });
    }

    public function ehPaiDe($id)
    {
        foreach ($this->contasFilhas()->get() as $contaFilha) {
            if ($contaFilha->id == $id || $contaFilha->ehPaiDe($id)) {
                return true;
            }
        }
    }

    public static function contasOptions($contaAtualId = 0, $tiposConta = [1, 2, 3, 4, 5, 6])
    {
        $contas = self::select('id', DB::raw('concat(codigo_completo, " ", nome) as nome'))
            ->where('id', '<>', $contaAtualId)
            ->whereIn(DB::raw('substr(codigo_completo, 1, 1)'), $tiposConta)
            ->orderBy('codigo_completo_ordenavel')
            ->pluck('nome', 'id');
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

    public function contasFilhas()
    {
        return $this->hasMany('App\Conta', 'conta_pai_id');
    }

    public function nivel()
    {
        return sizeof(explode('.', $this->codigo_completo));
    }

    public function getCodigoNomeAttribute()
    {
        return "$this->codigo_completo $this->nome";
    }

    public function getSaldoFormatadoAttribute()
    {
        return number_format($this->attributes['saldo'], 2, ',', '.');
    }

    public function getAumentaComDebitoAttribute()
    {
        return starts_with($this->codigo_completo, '1') || starts_with($this->codigo_completo, '5') || starts_with($this->codigo_completo, '6');
    }

    public function getAumentaComCreditoAttribute()
    {
        return starts_with($this->codigo_completo, '2') || starts_with($this->codigo_completo, '3') || starts_with($this->codigo_completo, '4');
    }

    public function lancamentosCredito()
    {
        return $this->hasMany('App\Lancamento', 'conta_credito_id');
    }

    public function lancamentosDebito()
    {
        return $this->hasMany('App\Lancamento', 'conta_debito_id');
    }
}
