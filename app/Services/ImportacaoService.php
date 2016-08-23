<?php namespace App\Services;

use App\ClassificacaoFruta;
use App\Conta;
use App\Data;
use App\LegadoTipoEmbalagem;
use App\MaterialEmbalagem;
use App\SaldoConta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ImportacaoService
{
    public static function importacao($path)
    {
        Conta::where('id', '>', 0)->forceDelete();

        $file = fopen($path, 'r');

        while (!feof($file)) {
            $row = fgetcsv($file, 0, "\t");
            if (preg_match('/^([\d\.]+)\s+(.*)/', $row[0], $matches)) {
                $codigoCompleto = $matches[1];
                $listaCodigoCompleto = explode('.', $codigoCompleto);

                $listaCodigoCompleto = array_map(function ($x) {
                    return intval($x);
                }, $listaCodigoCompleto);

                $codigo = array_pop($listaCodigoCompleto);
                $codigoPai = implode('.', $listaCodigoCompleto);
                $nome = utf8_encode($matches[2]);

                Log::info('criando conta ' . $nome . ' codigoPai: ' . $codigoPai . ' codigo: ' . $codigo);
                $contaPai = self::contaPai($codigoPai);

                $contaExistente = Conta::where('codigo', $codigo)->where('conta_pai_id', $contaPai ? $contaPai->id : null)->first();
                if ($contaExistente) {
                    Log::info('ja existe... atualizando');
                    $contaExistente->update(['nome' => $nome]);
                } else {
                    Conta::create([
                        'nome' => $nome,
                        'codigo' => $codigo,
                        'conta_pai_id' => $contaPai ? $contaPai->id : null
                    ]);
                }
            }
        }
    }

    private static function contaPai($codigoCompleto)
    {
        Log::info('buscando pai... codigoCompleto: ' . $codigoCompleto);
        if (!isset($codigoCompleto) || $codigoCompleto == '') {
            return null;
        }

        $contaPai = Conta::where('codigo_completo', $codigoCompleto)->first();
        if (!$contaPai) {
            Log::info('nao achou pai codigoCompleto: ' . $codigoCompleto);
            $listaCodigoCompleto = explode('.', $codigoCompleto);
            $codigo = array_pop($listaCodigoCompleto);
            $codigoPai = implode('.', $listaCodigoCompleto);

            Log::info('criando conta pai codigoPai: ' . $codigoPai . ' codigo: ' . $codigo);
            $contaPai = self::contaPai($codigoPai);
            $contaPai = Conta::create([
                'nome' => 'N/A',
                'codigo' => $codigo,
                'conta_pai_id' => $contaPai ? $contaPai->id : null
            ]);
        }
        return $contaPai;
    }

    public static function importacaoSaldos($path)
    {
//        SaldoConta::where('id', '>', 0)->forceDelete();
//        Data::where('id', '>', 0)->forceDelete();

        $file = fopen($path, 'r');

        while (!feof($file)) {
            $row = fgetcsv($file, 0, "\t");
            $lista[] = $row;

            if (sizeof($row) > 1 && preg_match('/^\d\d\/\d\d\d\d/', $row[1])) {
                array_shift($row);
                $meses = array_map(function ($mes) {
                    return Carbon::createFromDate(substr($mes, 3, 4), substr($mes, 0, 2))->lastOfMonth();
                }, $row);

                $datas = [];
                foreach ($meses as $mes) {
                    Log::info('criando mes...' . $mes);
                    $data = Data::create(['data' => $mes]);
                    $datas[] = $data;
                }
            }

            if (preg_match('/^([\d\.]+)\s+(.*)/', $row[0], $matches)) {
                $codigoCompleto = $matches[1];
                $listaCodigoCompleto = explode('.', $codigoCompleto);

                $listaCodigoCompleto = array_map(function ($x) {
                    return intval($x);
                }, $listaCodigoCompleto);

                $codigoCompleto = implode('.', $listaCodigoCompleto);
                $conta = Conta::where('codigo_completo', $codigoCompleto)->first();

                if ($conta) {
                    Log::info('importando conta ' . $conta->nome);
                    array_shift($row);
                    foreach ($datas as $key => $data) {
                        SaldoConta::create([
                            'conta_contabil_id' => $conta->id,
                            'data_id' => $data->id,
                            'saldo' => str_replace('.', '', $row[$key])
                        ]);
                    }
                } else {
                    Log::info('conta nao encontrada: ' . $codigoCompleto);
                }
            }
        }
    }

    public static function importarTiposEmbalagem()
    {
        // tipo_fruta
        $tipos = LegadoTipoEmbalagem::distinct()->pluck('tipo_fruta');
        foreach ($tipos as $tipo) {
            if ($tipo) {
                $jaExiste = ClassificacaoFruta::where('nome', $tipo)->first();
                Log::info('criando classificacao ' . $tipo);
                if ($jaExiste) {
                    Log::info('ja existe...');
                } else {
                    ClassificacaoFruta::create([
                        'nome' => $tipo,
                    ]);
                }
            }
        }

        // embalagem
        $materiais = LegadoTipoEmbalagem::distinct()->pluck('embalagem');
        foreach ($materiais as $material) {
            if ($material) {
                $jaExiste = MaterialEmbalagem::where('nome', $material)->first();
                Log::info('criando material ' . $material);
                if ($jaExiste) {
                    Log::info('ja existe...');
                } else {
                    MaterialEmbalagem::create([
                        'nome' => $material,
                        'descricao' => $material,
                    ]);
                }
            }
        }
    }
}