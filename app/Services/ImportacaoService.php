<?php namespace App\Services;

use App\Conta;
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
}