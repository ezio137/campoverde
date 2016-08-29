<?php namespace App\Services;

use App\ClassificacaoFruta;
use App\Cliente;
use App\Conta;
use App\Data;
use App\Fruta;
use App\ItemVenda;
use App\LegadoTipoEmbalagem;
use App\LegadoVenda;
use App\MaterialEmbalagem;
use App\SaldoConta;
use App\TipoEmbalagem;
use App\VariedadeFruta;
use App\Venda;
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
                $classificacaoExistente = ClassificacaoFruta::where('nome', $tipo)->first();
                Log::info('criando classificacao ' . $tipo);
                if ($classificacaoExistente) {
                    Log::info('ja existe...');
                } else {
                    ClassificacaoFruta::create([
                        'nome' => $tipo,
                    ]);
                }
            }
        }

        // material embalagem
        $materiais = LegadoTipoEmbalagem::distinct()->pluck('embalagem');
        foreach ($materiais as $material) {
            if ($material) {
                $materialExistente = MaterialEmbalagem::where('nome', $material)->first();
                Log::info('criando material ' . $material);
                if ($materialExistente) {
                    Log::info('ja existe...');
                    $materialExistente->update(['descricao' => $material]);
                } else {
                    MaterialEmbalagem::create([
                        'nome' => $material,
                        'descricao' => $material,
                    ]);
                }
            }
        }

        // tipos
        $tipos = LegadoTipoEmbalagem::all();
        foreach ($tipos as $tipo) {
            if ($tipo) {
                $tipoExistente = TipoEmbalagem::where('codigo_legado', $tipo->id)->first();
                Log::info('criando tipo ' . $tipo);
                $material = MaterialEmbalagem::where('nome', $tipo->embalagem)->first();
                $classificacao = ClassificacaoFruta::where('nome', $tipo->tipo_fruta)->first();
                $atributos = [
                    'nome' => $tipo->nome,
                    'peso' => $tipo->peso,
                    'codigo_legado' => $tipo->id,
                    'material_embalagem_id' => $material ? $material->id : null,
                    'classificacao_fruta_id' => $classificacao ? $classificacao->id : null,
                ];
                if ($tipoExistente) {
                    Log::info('ja existe...');
                    $tipoExistente->update($atributos);
                } else {
                    TipoEmbalagem::create($atributos);
                }
            }
        }
    }

    public static function importarVendasComRelacionamentos()
    {
        // clientes
        self::importarClientes();

        // frutas
        self::importarFrutas();

        // vendas
        self::importarVendas();

        // itens venda
        self::importarItensVenda();

    }

    /**
     * @return mixed
     */
    public static function importarClientes()
    {
        $clientes = LegadoVenda::distinct()->pluck('cliente');
        foreach ($clientes as $cliente) {
            if ($cliente) {
                $clienteExistente = Cliente::where('nome', $cliente)->first();
                Log::info('criando cliente ' . $cliente);
                if ($clienteExistente) {
                    Log::info('ja existe...');
                } else {
                    Cliente::create(['nome' => $cliente]);
                }
            }
        }
        return $cliente;
    }

    public static function importarFrutas()
    {
        $frutas = LegadoVenda::distinct()->pluck('produto');
        foreach ($frutas as $fruta) {
            if ($fruta) {
                $frutaExistente = Fruta::where('nome', $fruta)->first();
                $variedadeExistente = VariedadeFruta::where('nome', $fruta)->first();
                Log::info('criando fruta ' . $fruta);
                if ($frutaExistente) {
                    Log::info('ja existe...');
                } else {
                    $frutaExistente = Fruta::create(['nome' => $fruta]);
                }
                if ($variedadeExistente) {
                    Log::info('ja existe...');
                } else {
                    VariedadeFruta::create(['nome' => $fruta, 'fruta_id' => $frutaExistente->id]);
                }
            }
        }
    }

    /**
     * @return array
     */
    public static function importarVendas()
    {
        $vendas = LegadoVenda::distinct()->select('cliente', 'data_venda', 'periodo', 'ind_quitado', 'data_vencimento')->get();
        foreach ($vendas as $venda) {
            if ($venda) {
                $cliente = Cliente::where('nome', $venda->cliente)->first();
                $vendaExistente = Venda::where('cliente_id', $cliente->id)->where('data_venda', $venda->data_venda)->first();
                Log::info('criando venda ' . $venda->cliente . ' ' . $venda->data_venda);
                $atributos = [
                    'cliente_id' => $cliente->id,
                    'data_venda' => $venda->data_venda,
                    'periodo' => $venda->periodo,
                    'ind_quitado' => $venda->ind_quitado,
                    'data_vencimento' => $venda->data_vencimento,
                ];
                if ($vendaExistente) {
                    Log::info('ja existe...');
                    $vendaExistente->update($atributos);
                } else {
                    Venda::create($atributos);
                }
            }
        }
    }

    public static function importarItensVenda()
    {
        $legadoVendas = LegadoVenda::all();
        foreach ($legadoVendas as $legadoVenda) {
            if ($legadoVenda) {
                $cliente = Cliente::where('nome', $legadoVenda->cliente)->first();
                $venda = Venda::where('cliente_id', $cliente->id)->where('data_venda', $legadoVenda->data_venda)->first();
                $variedade = VariedadeFruta::where('nome', $legadoVenda->produto)->first();
                $embalagem = TipoEmbalagem::where('codigo_legado', $legadoVenda->codigo_tipo)->first();
                if ($variedade && $embalagem) {
                    $itemVendaExistente = ItemVenda::where('venda_id', $venda->id)
                        ->where('variedade_fruta_id', $variedade->id)
                        ->where('tipo_embalagem_id', $embalagem->id)
                        ->where('quantidade', $legadoVenda->quantidade)
                        ->first();
                    Log::info('criando item venda ' . $cliente->nome . ' ' . $legadoVenda->data_venda);
                    $atributos = [
                        'venda_id' => $venda->id,
                        'variedade_fruta_id' => $variedade ? $variedade->id : null,
                        'tipo_embalagem_id' => $embalagem ? $embalagem->id : null,
                        'quantidade' => $legadoVenda->quantidade,
                        'preco' => $legadoVenda->preco ?: 0.0,
                    ];
                    if ($itemVendaExistente) {
                        Log::info('ja existe...');
                        $itemVendaExistente->update($atributos);
                    } else {
                        ItemVenda::create($atributos);
                    }
                }
            }
        }
    }
}