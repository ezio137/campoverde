<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LancamentosTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed');
        \App\Lancamento::flushEventListeners();
        \App\Lancamento::boot();

        $this->contaAtivo        = \App\Conta::where('codigo_completo', 1)->first();
        $this->contaAtivoOutra   = \App\Conta::where('codigo_completo', 1.1)->first();
        $this->contaPassivo      = \App\Conta::where('codigo_completo', 2)->first();
        $this->contaPassivoOutra = \App\Conta::where('codigo_completo', 2.1)->first();
        $this->contaPL           = \App\Conta::where('codigo_completo', 3)->first();
        $this->contaPLOutra      = \App\Conta::where('codigo_completo', 3.1)->first();
        $this->contaReceita      = \App\Conta::where('codigo_completo', 4)->first();
        $this->contaReceitaOutra = \App\Conta::where('codigo_completo', 4.1)->first();
        $this->contaDespesa      = \App\Conta::where('codigo_completo', 5)->first();
        $this->contaDespesaOutra = \App\Conta::where('codigo_completo', 5.1)->first();

        $this->favorecido = \App\Favorecido::first();
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
    }

    public function testAumentoAtivo()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaAtivoOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaPassivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaPL->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(31.0, $this->contaAtivo->saldo);
        $this->assertEquals(-1.0, $this->contaAtivoOutra->saldo);
        $this->assertEquals(2.0, $this->contaPassivo->saldo);
        $this->assertEquals(4.0, $this->contaPL->saldo);
        $this->assertEquals(8.0, $this->contaReceita->saldo);
        $this->assertEquals(-16.0, $this->contaDespesa->saldo);
    }

    public function testReducaoAtivo()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaAtivoOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaPassivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaPL->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(-31.0, $this->contaAtivo->saldo);
        $this->assertEquals(1.0, $this->contaAtivoOutra->saldo);
        $this->assertEquals(-2.0, $this->contaPassivo->saldo);
        $this->assertEquals(-4.0, $this->contaPL->saldo);
        $this->assertEquals(-8.0, $this->contaReceita->saldo);
        $this->assertEquals(16.0, $this->contaDespesa->saldo);
    }

    public function testAumentoPassivo()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaAtivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaPassivoOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaPL->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(1.0, $this->contaAtivo->saldo);
        $this->assertEquals(31.0, $this->contaPassivo->saldo);
        $this->assertEquals(-2.0, $this->contaPassivoOutra->saldo);
        $this->assertEquals(-4.0, $this->contaPL->saldo);
        $this->assertEquals(-8.0, $this->contaReceita->saldo);
        $this->assertEquals(16.0, $this->contaDespesa->saldo);
    }

    public function testReducaoPassivo()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaAtivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaPassivoOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaPL->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(-1.0, $this->contaAtivo->saldo);
        $this->assertEquals(-31.0, $this->contaPassivo->saldo);
        $this->assertEquals(2.0, $this->contaPassivoOutra->saldo);
        $this->assertEquals(4.0, $this->contaPL->saldo);
        $this->assertEquals(8.0, $this->contaReceita->saldo);
        $this->assertEquals(-16.0, $this->contaDespesa->saldo);
    }

    public function testAumentoPL()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPL->id,
            'conta_debito_id' => $this->contaAtivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPL->id,
            'conta_debito_id' => $this->contaPassivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPL->id,
            'conta_debito_id' => $this->contaPLOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPL->id,
            'conta_debito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPL->id,
            'conta_debito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(1.0, $this->contaAtivo->saldo);
        $this->assertEquals(-2.0, $this->contaPassivo->saldo);
        $this->assertEquals(31.0, $this->contaPL->saldo);
        $this->assertEquals(-4.0, $this->contaPLOutra->saldo);
        $this->assertEquals(-8.0, $this->contaReceita->saldo);
        $this->assertEquals(16.0, $this->contaDespesa->saldo);
    }

    public function testReducaoPL()
    {
        factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPL->id,
            'conta_credito_id' => $this->contaAtivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPL->id,
            'conta_credito_id' => $this->contaPassivo->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPL->id,
            'conta_credito_id' => $this->contaPLOutra->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPL->id,
            'conta_credito_id' => $this->contaReceita->id,
        ]);

        factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPL->id,
            'conta_credito_id' => $this->contaDespesa->id,
        ]);

        $this->refreshModels();

        $this->assertEquals(-1.0, $this->contaAtivo->saldo);
        $this->assertEquals(2.0, $this->contaPassivo->saldo);
        $this->assertEquals(-31.0, $this->contaPL->saldo);
        $this->assertEquals(4.0, $this->contaPLOutra->saldo);
        $this->assertEquals(8.0, $this->contaReceita->saldo);
        $this->assertEquals(-16.0, $this->contaDespesa->saldo);
    }

    public function testAlteracaoAumentoAtivo()
    {
        $lancamentoAtivo = factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaAtivoOutra->id,
        ]);

        $lancamentoPassivo = factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaPassivo->id,
        ]);

        $lancamentoPL = factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaPL->id,
        ]);

        $lancamentoReceita = factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaReceita->id,
        ]);

        $lancamentoDespesa = factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaAtivo->id,
            'conta_credito_id' => $this->contaDespesa->id,
        ]);

        $lancamentoAtivo->update(['valor' => 16.0]);
        $lancamentoPassivo->update(['valor' => 8.0]);
        $lancamentoPL->update(['valor' => 4.0]);
        $lancamentoReceita->update(['valor' => 2.0]);
        $lancamentoDespesa->update(['valor' => 1.0]);

        $this->refreshModels();

        $this->assertEquals(31.0, $this->contaAtivo->saldo);
        $this->assertEquals(-16.0, $this->contaAtivoOutra->saldo);
        $this->assertEquals(8.0, $this->contaPassivo->saldo);
        $this->assertEquals(4.0, $this->contaPL->saldo);
        $this->assertEquals(2.0, $this->contaReceita->saldo);
        $this->assertEquals(-1.0, $this->contaDespesa->saldo);
    }

    public function testAlteracaoReducaoAtivo()
    {
        $lancamentoAtivo = factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaAtivoOutra->id,
        ]);

        $lancamentoPassivo = factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaPassivo->id,
        ]);

        $lancamentoPL = factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaPL->id,
        ]);

        $lancamentoReceita = factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaReceita->id,
        ]);

        $lancamentoDespesa = factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaAtivo->id,
            'conta_debito_id' => $this->contaDespesa->id,
        ]);

        $lancamentoAtivo->update(['valor' => 16.0]);
        $lancamentoPassivo->update(['valor' => 8.0]);
        $lancamentoPL->update(['valor' => 4.0]);
        $lancamentoReceita->update(['valor' => 2.0]);
        $lancamentoDespesa->update(['valor' => 1.0]);

        $this->refreshModels();

        $this->assertEquals(-31.0, $this->contaAtivo->saldo);
        $this->assertEquals(16.0, $this->contaAtivoOutra->saldo);
        $this->assertEquals(-8.0, $this->contaPassivo->saldo);
        $this->assertEquals(-4.0, $this->contaPL->saldo);
        $this->assertEquals(-2.0, $this->contaReceita->saldo);
        $this->assertEquals(1.0, $this->contaDespesa->saldo);
    }

    public function testAlteracaoAumentoPassivo()
    {
        $lancamentoAtivo = factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaAtivo->id,
        ]);

        $lancamentoPassivo = factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaPassivoOutra->id,
        ]);

        $lancamentoPL = factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaPL->id,
        ]);

        $lancamentoReceita = factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaReceita->id,
        ]);

        $lancamentoDespesa = factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_credito_id' => $this->contaPassivo->id,
            'conta_debito_id' => $this->contaDespesa->id,
        ]);

        $lancamentoAtivo->update(['valor' => 16.0]);
        $lancamentoPassivo->update(['valor' => 8.0]);
        $lancamentoPL->update(['valor' => 4.0]);
        $lancamentoReceita->update(['valor' => 2.0]);
        $lancamentoDespesa->update(['valor' => 1.0]);

        $this->refreshModels();

        $this->assertEquals(31.0, $this->contaPassivo->saldo);
        $this->assertEquals(16.0, $this->contaAtivo->saldo);
        $this->assertEquals(-8.0, $this->contaPassivoOutra->saldo);
        $this->assertEquals(-4.0, $this->contaPL->saldo);
        $this->assertEquals(-2.0, $this->contaReceita->saldo);
        $this->assertEquals(1.0, $this->contaDespesa->saldo);
    }

    public function testAlteracaoReducaoPassivo()
    {
        $lancamentoAtivo = factory(App\Lancamento::class)->create([
            'valor' => 1.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaAtivo->id,
        ]);

        $lancamentoPassivo = factory(App\Lancamento::class)->create([
            'valor' => 2.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaPassivoOutra->id,
        ]);

        $lancamentoPL = factory(App\Lancamento::class)->create([
            'valor' => 4.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaPL->id,
        ]);

        $lancamentoReceita = factory(App\Lancamento::class)->create([
            'valor' => 8.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaReceita->id,
        ]);

        $lancamentoDespesa = factory(App\Lancamento::class)->create([
            'valor' => 16.0,
            'favorecido_id' => $this->favorecido->id,
            'conta_debito_id' => $this->contaPassivo->id,
            'conta_credito_id' => $this->contaDespesa->id,
        ]);

        $lancamentoAtivo->update(['valor' => 16.0]);
        $lancamentoPassivo->update(['valor' => 8.0]);
        $lancamentoPL->update(['valor' => 4.0]);
        $lancamentoReceita->update(['valor' => 2.0]);
        $lancamentoDespesa->update(['valor' => 1.0]);

        $this->refreshModels();

        $this->assertEquals(-31.0, $this->contaPassivo->saldo);
        $this->assertEquals(-16.0, $this->contaAtivo->saldo);
        $this->assertEquals(8.0, $this->contaPassivoOutra->saldo);
        $this->assertEquals(4.0, $this->contaPL->saldo);
        $this->assertEquals(2.0, $this->contaReceita->saldo);
        $this->assertEquals(-1.0, $this->contaDespesa->saldo);
    }

    protected function refreshModels()
    {
        $this->contaAtivo = $this->contaAtivo->fresh();
        $this->contaAtivoOutra = $this->contaAtivoOutra->fresh();
        $this->contaPassivo = $this->contaPassivo->fresh();
        $this->contaPassivoOutra = $this->contaPassivoOutra->fresh();
        $this->contaPL = $this->contaPL->fresh();
        $this->contaPLOutra = $this->contaPLOutra->fresh();
        $this->contaReceita = $this->contaReceita->fresh();
        $this->contaReceitaOutra = $this->contaReceitaOutra->fresh();
        $this->contaDespesa = $this->contaDespesa->fresh();
        $this->contaDespesaOutra = $this->contaDespesaOutra->fresh();
    }
}
