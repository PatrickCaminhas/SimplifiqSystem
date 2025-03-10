<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Models\Vendas;
use App\Models\Itens_venda;
use App\Models\Produtos;
use App\Models\Clientes;
use App\Models\Estoque;
use App\Models\HistoricoFaturamento;
use App\Services\metaService;

use Illuminate\Http\Request;
use App\Http\Controllers\VendasController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;


class VendasTestUnit extends TestCase
{
    use MakesHttpRequests, RefreshDatabase, InteractsWithDatabase;
    use MakesHttpRequests, RefreshDatabase;

    public function test_create_view_returns_correct_data()
    {
        $cliente = Clientes::factory()->create();
        $produto = Produtos::factory()->create();

        $controller = new VendasController(new MetaService());
        $response = $this->get(route('vendas.create'));

        $response->assertStatus(200);
        $response->assertViewHas(['produtos', 'clientes']);
    }

    public function test_store_creates_venda_and_items()
    {
        $cliente = Clientes::factory()->create();
        $produto = Produtos::factory()->create(['quantidade' => 10]);

        $requestData = [
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Cartão',
            'quantidades' => [
                $produto->id => 2,
            ],
        ];



        $controller = new VendasController(new MetaService());
        $request = Request::create(route('vendas.store'), 'POST', $requestData);

        DB::beginTransaction();
        $response = $controller->store($request);
        DB::commit();

        $this->assertDatabaseHas('vendas', ['cliente_id' => $cliente->id]);
        $this->assertDatabaseHas('itens_venda', ['produto_id' => $produto->id, 'quantidade' => 2]);
        $this->assertDatabaseHas('estoques', ['id_produto' => $produto->id, 'acao' => 'Venda']);
    }

    public function test_clienteCrediario_updates_credit()
    {
        $cliente = Clientes::factory()->create(['crediario' => 0]);
        $controller = new VendasController(new MetaService());

        $controller->clienteCrediario($cliente->id, 100);

        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'crediario' => 100]);
    }

    public function test_atualizarFaturamento_updates_or_creates_faturamento()
    {
        $controller = new VendasController(new MetaService());

        $controller->atualizarFaturamento(500);

        $this->assertDatabaseHas('historico_faturamento', ['ano_mes' => date('Y-m'), 'renda_bruta' => 500]);
    }
}
