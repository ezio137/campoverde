<?php

use Illuminate\Database\Seeder;
use \App\Conta;

class ContasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ativo   = Conta::create(['nome' => 'Ativo']);
        $passivo = Conta::create(['nome' => 'Passivo']);
        $pl      = Conta::create(['nome' => 'Patrimônio Líquido']);
        $receita = Conta::create(['nome' => 'Receita']);
        $despesa = Conta::create(['nome' => 'Despesa']);

        // 1
        // 1.1
        $ativoCirculante = Conta::create(['nome' => 'Circulante', 'conta_pai_id' => $ativo->id]);

        // 1.1.1
        $disponivel = Conta::create(['nome' => 'Disponível', 'conta_pai_id' => $ativoCirculante->id]);
        $caixa = Conta::create(['nome' => 'Caixa', 'conta_pai_id' => $disponivel->id]);
        Conta::create(['nome' => 'FA / CA', 'conta_pai_id' => $caixa->id]);

        $bancos = Conta::create(['nome' => 'Bancos', 'conta_pai_id' => $disponivel->id]);
        Conta::create(['nome' => 'EZ / CR', 'conta_pai_id' => $bancos->id]);
        Conta::create(['nome' => 'EZ / CE', 'conta_pai_id' => $bancos->id]);
        Conta::create(['nome' => 'JU / BB', 'conta_pai_id' => $bancos->id]);

        // 1.1.2
        $creditos = Conta::create(['nome' => 'Créditos', 'conta_pai_id' => $ativoCirculante->id]);

        // 1.1.2.1
        Conta::create(['nome' => 'Cheques',          'conta_pai_id' => $creditos->id]);
        // 1.1.2.2
        $contasReceber = Conta::create(['nome' => 'Contas a Receber', 'conta_pai_id' => $creditos->id]);
        Conta::create(['nome' => 'Depósitos', 'conta_pai_id' => $contasReceber->id]);
        Conta::create(['nome' => 'Clientes JA', 'conta_pai_id' => $contasReceber->id]);
        Conta::create(['nome' => 'Clientes FA', 'conta_pai_id' => $contasReceber->id]);
        Conta::create(['nome' => 'Outros Clientes', 'conta_pai_id' => $contasReceber->id]);
        // 1.1.2.3
        Conta::create(['nome' => 'Vales',            'conta_pai_id' => $creditos->id]);
        // 1.1.2.4
        Conta::create(['nome' => 'Créditos',         'conta_pai_id' => $creditos->id]);
        // 1.1.2.5
        Conta::create(['nome' => 'Valores em Haver', 'conta_pai_id' => $creditos->id]);

        // 1.1.3
        Conta::create(['nome' => 'Empréstimos de Curto Prazo', 'conta_pai_id' => $ativoCirculante->id]);

        // 1.1.4
        $despesasExercicioSeguinte = Conta::create(['nome' => 'Despesas do Exercício Seguinte', 'conta_pai_id' => $ativoCirculante->id]);
        Conta::create(['nome' => 'Insumos',                      'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Combustíveis e Lubrificantes', 'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Embalagens',                   'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Estoque Geral',                'conta_pai_id' => $despesasExercicioSeguinte->id]);

        // 1.1.5
        Conta::create(['nome' => 'Outros Ativos Circulantes', 'conta_pai_id' => $ativoCirculante->id]);

        // 1.2
        $realizavelLongoPrazo = Conta::create(['nome' => 'Realizável a Longo Prazo', 'conta_pai_id' => $ativo->id]);
        Conta::create(['nome' => 'Empréstimos de Longo Prazo', 'conta_pai_id' => $realizavelLongoPrazo->id]);
        Conta::create(['nome' => 'Capitalizações',             'conta_pai_id' => $realizavelLongoPrazo->id]);

        // 1.3
        $permanente = Conta::create(['nome' => 'Permanente', 'conta_pai_id' => $ativo->id]);

        // 1.3.1
        $investimento = Conta::create(['nome' => 'Investimento', 'conta_pai_id' => $permanente->id]);
        Conta::create(['nome' => 'Ações',      'conta_pai_id' => $investimento->id]);
        Conta::create(['nome' => 'Aplicações', 'conta_pai_id' => $investimento->id]);

        // 1.3.2
        $imobilizado = Conta::create(['nome' => 'Imobilizado', 'conta_pai_id' => $permanente->id]);
        Conta::create(['nome' => 'Terrenos',                'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Edifícios',               'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Pomares',                 'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Máquinas e Equipamentos', 'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Veículos',                'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Caixas',                  'conta_pai_id' => $imobilizado->id]);
        Conta::create(['nome' => 'Outros Bens',             'conta_pai_id' => $imobilizado->id]);

        // 1.3.3
        Conta::create(['nome' => 'Diferido', 'conta_pai_id' => $permanente->id]);

        // 2
        // 2.1
        $passivoCirculante = Conta::create(['nome' => 'Circulante', 'conta_pai_id' => $passivo->id]);
        // 2.1.1
        $contasPagar = Conta::create(['nome' => 'Contas a Pagar', 'conta_pai_id' => $passivoCirculante->id]);
        // 2.1.1.1
        $despesasPrazo = Conta::create(['nome' => 'Despesas a Prazo', 'conta_pai_id' => $contasPagar->id]);
        Conta::create(['nome' => 'Despesas Gerais', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Fruta a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Frete a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Embalagens a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Insumos a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Manutenção a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Combustíveis a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Seguros a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        Conta::create(['nome' => 'Impostos a Pagar', 'conta_pai_id' => $despesasPrazo->id]);
        // 2.1.1.2
        $despesasMensais = Conta::create(['nome' => 'Despesas Mensais', 'conta_pai_id' => $contasPagar->id]);
        Conta::create(['nome' => 'Energia e Telefone', 'conta_pai_id' => $despesasMensais->id]);
        Conta::create(['nome' => 'INSS a Pagar', 'conta_pai_id' => $despesasMensais->id]);
        Conta::create(['nome' => 'FGTS a Pagar', 'conta_pai_id' => $despesasMensais->id]);
        // 2.1.1.3
        Conta::create(['nome' => 'Cartões de Crédito', 'conta_pai_id' => $contasPagar->id]);
        // 2.1.2
        $salariosPagar = Conta::create(['nome' => 'Salários a Pagar', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Mensal a Pagar', 'conta_pai_id' => $salariosPagar->id]);
        Conta::create(['nome' => 'Provisão para Férias', 'conta_pai_id' => $salariosPagar->id]);
        Conta::create(['nome' => 'Provisão para 13º', 'conta_pai_id' => $salariosPagar->id]);
        Conta::create(['nome' => 'Temporária a Pagar Sáb-Sex', 'conta_pai_id' => $salariosPagar->id]);
        Conta::create(['nome' => 'Temporária a Pagar Outros', 'conta_pai_id' => $salariosPagar->id]);
        // 2.1.3
        $emprestimosCurtoPrazo = Conta::create(['nome' => 'Empréstimos de Curto Prazo', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Bancários', 'conta_pai_id' => $emprestimosCurtoPrazo->id]);
        Conta::create(['nome' => 'Pessoais', 'conta_pai_id' => $emprestimosCurtoPrazo->id]);
        Conta::create(['nome' => 'Empresariais', 'conta_pai_id' => $emprestimosCurtoPrazo->id]);
        // 2.1.4
        Conta::create(['nome' => 'Valores em Dever',            'conta_pai_id' => $passivoCirculante->id]);
        // 2.1.5
        Conta::create(['nome' => 'Empréstimos Futuros',         'conta_pai_id' => $passivoCirculante->id]);
        // 2.1.6
        Conta::create(['nome' => 'Cheques Devolvidos',          'conta_pai_id' => $passivoCirculante->id]);
        // 2.1.7
        Conta::create(['nome' => 'Outros Passivos Circulantes', 'conta_pai_id' => $passivoCirculante->id]);

        // 2.2
        $exigivelLongoPrazo = Conta::create(['nome' => 'Exigível a Longo Prazo', 'conta_pai_id' => $passivo->id]);
        // 2.2.1
        $emprestimosLongoPrazo = Conta::create(['nome' => 'Empréstimos de Longo Prazo', 'conta_pai_id' => $exigivelLongoPrazo->id]);
        Conta::create(['nome' => 'Bancários', 'conta_pai_id' => $emprestimosLongoPrazo->id]);
        Conta::create(['nome' => 'Pessoais', 'conta_pai_id' => $emprestimosLongoPrazo->id]);

        // 3
        Conta::create(['nome' => 'Capital Inicial',             'conta_pai_id' => $pl->id]);
        Conta::create(['nome' => 'Lucros/Prejuízos Acumulados', 'conta_pai_id' => $pl->id]);

        // 4
        Conta::create(['nome' => 'Vendas',      'conta_pai_id' => $receita->id]);
        Conta::create(['nome' => 'Financeiras', 'conta_pai_id' => $receita->id]);

        // 5
        Conta::create(['nome' => 'Custos',   'conta_pai_id' => $despesa->id]);
        Conta::create(['nome' => 'Despesas', 'conta_pai_id' => $despesa->id]);
    }
}
