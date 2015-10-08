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
            if (preg_match('/^([\d\.]*\d)\.(\d+)\s+(.*)/', $row[0], $matches)) {
                $codigoPai = $matches[1];
                $codigo = $matches[2];
                $nome = utf8_encode($matches[3]);

                $contaPai = self::contaPai($codigoPai);
                Log::info('criando conta ' . $nome . ' codigoPai: ' . $codigoPai . ' codigo: ' . $codigo . ' id_pai: ' . $contaPai->id);

                $contaExistente = Conta::where('codigo', $codigo)->where('conta_pai_id', $contaPai->id)->first();
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
        if (!isset($codigoCompleto)) {
            return null;
        }

        $contaPai = Conta::where('codigo_completo', $codigoCompleto)->first();
        if (!$contaPai) {
            Log::info('nao achou pai codigoCompleto: ' . $codigoCompleto);
            if (preg_match('/([\d\.]*\d)\.(\d+)/', $codigoCompleto, $matches)) {
                $codigoPai = $matches[1];
                $codigo = $matches[2];
            } else {
                $codigoPai = null;
                $codigo = $codigoCompleto;
            }
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