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
        $disponivel = Conta::create(['nome' => 'Disponível', 'conta_pai_id' => $ativoCirculante->id]);
        Conta::create(['nome' => 'Caixa', 'conta_pai_id' => $disponivel->id]);
        Conta::create(['nome' => 'Bancos', 'conta_pai_id' => $disponivel->id]);

        $creditos = Conta::create(['nome' => 'Créditos', 'conta_pai_id' => $ativoCirculante->id]);
        Conta::create(['nome' => 'Cheques', 'conta_pai_id' => $creditos->id]);
        Conta::create(['nome' => 'Contas a receber', 'conta_pai_id' => $creditos->id]);
        Conta::create(['nome' => 'Vales', 'conta_pai_id' => $creditos->id]);
        Conta::create(['nome' => 'Créditos', 'conta_pai_id' => $creditos->id]);
        Conta::create(['nome' => 'Valores em Haver', 'conta_pai_id' => $creditos->id]);

        Conta::create(['nome' => 'Empréstimos de Curto Prazo', 'conta_pai_id' => $ativoCirculante->id]);

        $despesasExercicioSeguinte = Conta::create(['nome' => 'Despesas do Exercício Seguinte', 'conta_pai_id' => $ativoCirculante->id]);
        Conta::create(['nome' => 'Insumos', 'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Combustíveis e Lubrificantes', 'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Embalagens', 'conta_pai_id' => $despesasExercicioSeguinte->id]);
        Conta::create(['nome' => 'Estoque Geral', 'conta_pai_id' => $despesasExercicioSeguinte->id]);

        Conta::create(['nome' => 'Outros Ativos Circulantes', 'conta_pai_id' => $ativoCirculante->id]);

        // 1.2
        $realizavelLongoPrazo = Conta::create(['nome' => 'Realizável a Longo Prazo', 'conta_pai_id' => $ativo->id]);
        Conta::create(['nome' => 'Empréstimos de Longo Prazo', 'conta_pai_id' => $realizavelLongoPrazo->id]);
        Conta::create(['nome' => 'Capitalizações', 'conta_pai_id' => $realizavelLongoPrazo->id]);

        // 1.3
        $permanente = Conta::create(['nome' => 'Permanente', 'conta_pai_id' => $ativo->id]);
        $investimento = Conta::create(['nome' => 'Investimento', 'conta_pai_id' => $permanente->id]);
        Conta::create(['nome' => 'Ações', 'conta_pai_id' => $investimento->id]);
        Conta::create(['nome' => 'Aplicações', 'conta_pai_id' => $investimento->id]);

        $imobilizado = Conta::create(['nome' => 'Imobilizado', 'conta_pai_id' => $permanente->id]);
        Conta::create(['nome' => 'Terrenos', 'conta_pai_id' => $imobilizado->id]);

        Conta::create(['nome' => 'Diferido', 'conta_pai_id' => $permanente->id]);

        // 2
        // 2.1
        $passivoCirculante = Conta::create(['nome' => 'Circulante', 'conta_pai_id' => $passivo->id]);
        Conta::create(['nome' => 'Contas a Pagar', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Salários a Pagar', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Empréstimos de Curto Prazo', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Valores em Dever', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Empréstimos Futuros', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Cheques Devolvidos', 'conta_pai_id' => $passivoCirculante->id]);
        Conta::create(['nome' => 'Outros Passivos Circulantes', 'conta_pai_id' => $passivoCirculante->id]);

        // 2.2
        $exigivelLongoPrazo = Conta::create(['nome' => 'Exigível a Longo Prazo', 'conta_pai_id' => $passivo->id]);
        Conta::create(['nome' => 'Empréstimos de Longo Prazo', 'conta_pai_id' => $exigivelLongoPrazo->id]);

        // 3
        Conta::create(['nome' => 'Capital Inicial', 'conta_pai_id' => $pl->id]);
        Conta::create(['nome' => 'Lucros/Prejuízos Acumulados', 'conta_pai_id' => $pl->id]);

        // 4
        Conta::create(['nome' => 'Vendas', 'conta_pai_id' => $receita->id]);
        Conta::create(['nome' => 'Financeiras', 'conta_pai_id' => $receita->id]);

        // 5
        Conta::create(['nome' => 'Custos', 'conta_pai_id' => $despesa->id]);
        Conta::create(['nome' => 'Despesas', 'conta_pai_id' => $despesa->id]);
    }
}
