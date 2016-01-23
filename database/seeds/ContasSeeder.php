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
        $ativo = Conta::create(['codigo' => 1, 'nome' => 'Ativo']);
        $passivo = Conta::create(['codigo' => 2, 'nome' => 'Passivo']);
        $pl = Conta::create(['codigo' => 3, 'nome' => 'Patrimônio Líquido']);
        $receita = Conta::create(['codigo' => 4, 'nome' => 'Receita']);
        $despesa = Conta::create(['codigo' => 5, 'nome' => 'Despesa']);

        Conta::create(['codigo' => 1, 'nome' => 'Circulante', 'conta_pai_id' => $ativo->id]);
        Conta::create(['codigo' => 3, 'nome' => 'Permanente', 'conta_pai_id' => $ativo->id]);
        Conta::create(['codigo' => 2, 'nome' => 'Realizável a Longo Prazo', 'conta_pai_id' => $ativo->id]);

        Conta::create(['codigo' => 1, 'nome' => 'Circulante', 'conta_pai_id' => $passivo->id]);
        Conta::create(['codigo' => 2, 'nome' => 'Exigível a Longo Prazo', 'conta_pai_id' => $passivo->id]);

        Conta::create(['codigo' => 1, 'nome' => 'Capital Inicial', 'conta_pai_id' => $pl->id]);
        Conta::create(['codigo' => 2, 'nome' => 'Lucros/Prejuízos Acumulados', 'conta_pai_id' => $pl->id]);

        Conta::create(['codigo' => 1, 'nome' => 'Vendas', 'conta_pai_id' => $receita->id]);
        Conta::create(['codigo' => 2, 'nome' => 'Financeiras', 'conta_pai_id' => $receita->id]);

        Conta::create(['codigo' => 1, 'nome' => 'Custos', 'conta_pai_id' => $despesa->id]);
        Conta::create(['codigo' => 2, 'nome' => 'Despesas', 'conta_pai_id' => $despesa->id]);
    }
}
