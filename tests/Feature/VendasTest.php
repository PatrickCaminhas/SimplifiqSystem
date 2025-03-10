<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Produtos;
use App\Models\Clientes;
use App\Models\Vendas;
use App\Models\Itens_venda;
use App\Models\Estoque;
use App\Models\HistoricoFaturamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class VendasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Cria um usuário para autenticação
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testCreateRetornaViewComProdutosEClientes()
    {
        // Cria dados de teste
        Produtos::create([
            'nome' => 'Produto 1',
            'preco_venda' => 100,
            'quantidade' => 50,
        ]);

        Clientes::create([
            'nome' => 'Cliente 1',
            'crediario' => 0,
        ]);

        // Supondo que você tenha uma rota nomeada 'vendas.create'
        $response = $this->get(route('vendas.create'));
        $response->assertStatus(200);
        $response->assertViewIs('sistema.venda.cadastrarVenda');
        $response->assertViewHas(['produtos', 'clientes']);
    }

    public function testInfoRetornaViewComVendas()
    {
        // Cria uma venda simples para o teste
        $cliente = Clientes::create(['nome' => 'Cliente 1', 'crediario' => 0]);
        Vendas::create([
            'cliente_id' => $cliente->id,
            'data_venda' => now(),
            'metodo_pagamento' => 'Dinheiro',
            'valor_total' => 100,
        ]);

        // Supondo que a rota seja 'vendas.info'
        $response = $this->get(route('vendas.info'));
        $response->assertStatus(200);
        $response->assertViewIs('sistema.venda.listaVendas');
        $response->assertViewHas('vendas');
    }

    public function testClienteCrediarioIncrementaValorCorretamente()
    {
        $cliente = Clientes::create(['nome' => 'Cliente 1', 'crediario' => 100]);
        // Instancia o controller passando a service necessária
        $controller = new \App\Http\Controllers\VendasController(new \App\Services\metaService());
        $controller->clienteCrediario($cliente->id, 50);

        $cliente->refresh();
        $this->assertEquals(150, $cliente->crediario);
    }

    public function testStoreCriaVendaEAtualizaEstoqueEFaturamento()
    {
        // Prepara os dados para a venda
        $cliente = Clientes::create(['nome' => 'Cliente 1', 'crediario' => 0]);
        $produto = Produtos::create([
            'nome' => 'Produto 1',
            'preco_venda' => 100,
            'quantidade' => 10,
        ]);

        $postData = [
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Dinheiro',
            // Se o valor_venda for nulo, o total é calculado automaticamente
            'valor_venda' => null,
            'desconto_maximo' => 50,
            'quantidades' => [
                $produto->id => 2
            ]
        ];

        // Supondo que a rota seja 'vendas.store'
        $response = $this->post(route('vendas.store'), $postData);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifica se a venda foi criada
        $venda = Vendas::first();
        $this->assertNotNull($venda);
        $this->assertEquals($cliente->id, $venda->cliente_id);
        $this->assertEquals('Dinheiro', $venda->metodo_pagamento);
        $this->assertEquals(200, $venda->valor_total);

        // Verifica se o item da venda foi criado corretamente
        $item = Itens_venda::where('venda_id', $venda->id)->first();
        $this->assertNotNull($item);
        $this->assertEquals(2, $item->quantidade);
        $this->assertEquals(100, $item->preco_unitario);
        $this->assertEquals(200, $item->subtotal);

        // Verifica a atualização do estoque do produto
        $produto->refresh();
        $this->assertEquals(8, $produto->quantidade);

        // Verifica se o faturamento foi atualizado
        $faturamento = HistoricoFaturamento::where('ano_mes', date('Y') . "-" . date('m'))->first();
        $this->assertNotNull($faturamento);
        $this->assertEquals(200, $faturamento->renda_bruta);
    }

    public function testStoreFalhaQuandoEstoqueInsuficiente()
    {
        // Prepara dados onde o estoque é insuficiente
        $cliente = Clientes::create(['nome' => 'Cliente 1', 'crediario' => 0]);
        $produto = Produtos::create([
            'nome' => 'Produto 1',
            'preco_venda' => 100,
            'quantidade' => 1, // estoque insuficiente para a quantidade solicitada
        ]);

        $postData = [
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Dinheiro',
            'valor_venda' => null,
            'desconto_maximo' => 50,
            'quantidades' => [
                $produto->id => 2
            ]
        ];

        $response = $this->post(route('vendas.store'), $postData);
        // Espera erro de validação ou mensagem de erro na sessão
        $response->assertSessionHasErrors();

        // Verifica que nenhuma venda foi criada
        $this->assertEquals(0, Vendas::count());
    }
}
