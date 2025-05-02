<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\Produtos;
use App\Models\Produtos_categoria;
use App\Models\Itens_venda;
use App\Models\Vendas;
use App\Models\Clientes;
use App\Models\Itens_cotacoes;
use App\Models\Fornecedores;
use Carbon\Carbon;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class ClienteControllerTest extends TestCase
{


    use RefreshDatabase;

    // Teste para store - Cadastrar cliente
    public function test_store_cliente_success()
    {
        $controller = new ClienteController();

        $request = new Request([
            'nome' => 'João Silva',
            'cpfOuCnpj' => '123.456.789-00',
            'telefone' => '(11) 9999-9999',
            'endereco_completo' => 'Rua Teste, 123'
        ]);

        $response = $controller->store($request);

        $this->assertDatabaseHas('clientes', [
            'cpfOuCnpj' => '123.456.789-00'
        ]);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_store_duplicate_cpf_cnpj()
    {
        Clientes::factory()->create(['cpfOuCnpj' => '123.456.789-00']);
        $controller = new ClienteController();

        $request = new Request([
            'nome' => 'João Silva',
            'cpfOuCnpj' => '123.456.789-00',
            'telefone' => '(11) 9999-9999',
            'endereco_completo' => 'Rua Teste, 123'
        ]);

        $response = $controller->store($request);
        $this->assertEquals(409, $response->getStatusCode());
    }

    // Teste para update - Atualizar cliente
    public function test_update_cliente_success()
    {
        $cliente = Clientes::factory()->create();
        $controller = new ClienteController();

        $request = new Request([
            'id' => $cliente->id,
            'nome' => 'Novo Nome',
            'cpfOuCnpj' => $cliente->cpfOuCnpj,
            'telefone' => '(11) 8888-8888',
            'endereco_completo' => 'Novo Endereço'
        ]);

        $response = $controller->update($request);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'telefone' => '(11) 8888-8888'
        ]);
    }

    // Teste para quitar dívida
    public function test_quitar_divida_full_payment()
    {
        $cliente = Clientes::factory()->create(['crediario' => 500]);
        $venda = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'crediario' => 500,
            'metodo_pagamento' => 'Crediário'
        ]);

        $controller = new ClienteController();
        $request = new Request([
            'cliente_id' => $cliente->id,
            'valor_quitacao' => 500
        ]);

        $response = $controller->quitarDividaStore($request);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'crediario' => 0
        ]);
        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'metodo_pagamento' => 'Crediário(Pago)'
        ]);
    }

    public function test_quitar_divida_partial_payment()
    {
        $cliente = Clientes::factory()->create(['crediario' => 1000]);
        $venda = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'crediario' => 1000,
            'metodo_pagamento' => 'Crediário'
        ]);

        $controller = new ClienteController();
        $request = new Request([
            'cliente_id' => $cliente->id,
            'valor_quitacao' => 300
        ]);

        $response = $controller->quitarDividaStore($request);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'crediario' => 700
        ]);
        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'metodo_pagamento' => 'Crediário(Pago Parcial)'
        ]);
    }

    public function test_quitar_divida_excess_payment()
    {
        $cliente = Clientes::factory()->create(['crediario' => 500]);
        $controller = new ClienteController();

        $request = new Request([
            'cliente_id' => $cliente->id,
            'valor_quitacao' => 600
        ]);

        $response = $controller->quitarDividaStore($request);
        $this->assertStringContainsString('Valor de quitação maior que o valor da dívida!', session()->get('error'));
    }

    // Teste para delete
    public function test_delete_cliente()
    {
        $cliente = Clientes::factory()->create();
        $controller = new ClienteController();

        $request = new Request(['id' => $cliente->id]);
        $response = $controller->delete($request);

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    // Teste para buscar produtos mais comprados
    public function test_buscar_produtos_mais_comprados()
    {
        $cliente = Clientes::factory()->create();
        $produto = Produtos::factory()->create();

        $venda = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Dinheiro'
        ]);

        Itens_venda::factory()->create([
            'venda_id' => $venda->id,
            'produto_id' => $produto->id,
            'quantidade' => 5
        ]);

        $controller = new ClienteController();
        $response = $controller->buscarProdutosMaisComprados($cliente->id);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(5, $responseData[0]['total_comprado']);
        $this->assertEquals($produto->id, $responseData[0]['produto_id']);
    }
}
