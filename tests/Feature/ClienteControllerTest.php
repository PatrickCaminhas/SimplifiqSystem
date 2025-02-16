<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use App\Models\Clientes;
use App\Models\Vendas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mudarEstadoVendaCrediario_atualiza_vendas_corretamente()
    {
        $cliente = Clientes::factory()->create(['debitos' => 100]);

        $venda1 = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => 50,
        ]);

        $venda2 = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => 50,
        ]);

        $controller = new \App\Http\Controllers\ClienteController();
        $controller->mudarEstadoVendaCrediario(75, $cliente);

        $this->assertEquals('Crediário(Pago)', $venda1->fresh()->metodo_pagamento);
        $this->assertEquals(0, $venda1->fresh()->crediario);
        $this->assertEquals('Crediário(Pago Parcial)', $venda2->fresh()->metodo_pagamento);
        $this->assertEquals(25, $venda2->fresh()->crediario);
    }

    /** @test */
    public function store_cadastra_cliente_com_sucesso()
    {
        $response = $this->post('/clientes', [
            'nome' => 'Cliente Teste',
            'cpfOuCnpj' => '12345678900',
            'telefone' => '11999999999',
            'email' => 'cliente@teste.com',
            'endereco_completo' => 'Rua Teste, 123',
        ]);

        $response->assertRedirect('clientes');
        $this->assertDatabaseHas('clientes', ['cpfOuCnpj' => '12345678900']);
    }

    /** @test */
    public function update_altera_dados_do_cliente()
    {
        $cliente = Clientes::factory()->create();

        $response = $this->put("/clientes/{$cliente->id}", [
            'nome' => 'Cliente Alterado',
            'cpfOuCnpj' => $cliente->cpfOuCnpj,
            'telefone' => '11888888888',
            'email' => 'cliente@alterado.com',
            'endereco_completo' => 'Rua Alterada, 456',
        ]);

        $response->assertRedirect('clientes');
        $this->assertDatabaseHas('clientes', ['nome' => 'Cliente Alterado']);
    }

    /** @test */
    public function quitarDividaStore_atualiza_debito_do_cliente()
    {
        $cliente = Clientes::factory()->create(['debitos' => 100]);

        $response = $this->post('/clientes/quitar-divida', [
            'cliente_id' => $cliente->id,
            'valor_quitacao' => 50,
        ]);

        $response->assertRedirect('clientes');
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'debitos' => 50]);
    }
}
