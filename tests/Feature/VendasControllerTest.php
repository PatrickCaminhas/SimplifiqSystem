<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use App\Models\HistoricoFaturamento;
use App\Services\MetaService;
use App\Models\Clientes;
use App\Http\Controllers\VendasController;
use App\Models\Produtos;
use App\Models\User;
use App\Models\Vendas;
use App\Http\Controllers\ClienteController;
use App\Models\Funcionarios;
use App\Models\Empresas;
use App\Models\Estoque;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Illuminate\Http\Request;
use App\Models\Itens_venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;

class VendasControllerTest extends TestCase
{
    use RefreshDatabase; // Isso resolve o erro do banco de dados

    /*
        public function test_deve_carregar_view_com_dados_corretos()
        {
            $user = Funcionarios::factory()->create();
            $this->actingAs($user);
            // Preparar dados
            Produtos::factory(3)->create();
            Clientes::factory(5)->create();

            // Executar
            $response = $this->get(route('vendas.create'));

            // Verificar
            $response->assertOk()
                ->assertViewIs('sistema.venda.cadastrarVenda')
                ->assertViewHas([
                    'produtos' => Produtos::all(),
                    'clientes' => Clientes::all(),
                    'page' => 'Vendas'
                ]);
        }
    */
    public function test_deve_carregar_view_com_dados_corretos()
    {
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        // Preparar dados
        Produtos::factory(3)->create();
        Clientes::factory(5)->create();

        // Executar
        $response = $this->get(route('vendas.create'));

        // Verificar
        $response->assertOk()
            ->assertViewIs('sistema.venda.cadastrarVenda')
            ->assertViewHas([
                'produtos' => Produtos::all(),
                'clientes' => Clientes::all(),
                'page' => 'Vendas'
            ]);
    }

    public function test_deve_lidar_com_lista_vazia()
    {
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('vendas.info'));

        $response->assertViewHas('vendas', function ($vendas) {
            return $vendas->isEmpty();
        });
    }

    public function test_deve_exibir_dados_corretos_na_view()
    {
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        Vendas::factory()->create(['valor_total' => 150.75]);

        $response = $this->get(route('vendas.info'));

        $response->assertSee('150.75'); // Ajustar para formato usado na view
    }

    public function test_deve_fazer_rollback_se_estoque_insuficiente()
    {
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        $produto = Produtos::factory()->create(['quantidade' => 2]);

        $dados = [
            'cliente_id' => 1,
            'metodo_pagamento' => 'Cartão',
            'quantidades' => [
                $produto->id => 5
            ]
        ];

        $response = $this->post(route('vendas.store'), $dados);

        $response->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseCount('vendas', 0);
        $this->assertEquals(2, $produto->fresh()->quantidade);
    }




    public function test_atualizar_faturamento_quando_registro_existe()
    {
        HistoricoFaturamento::create([
            'ano_mes' => date('Y') . "-" . date('m'),
            'renda_bruta' => 1000.00
        ]);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);

        $controller->atualizarFaturamento(500.00);

        $this->assertDatabaseHas('historico_faturamentos', [
            'ano_mes' => date('Y') . "-" . date('m'),
            'renda_bruta' => 1500.00
        ]);
    }


    public function test_atualizar_renda_bruta_quando_registro_nao_existe()
    {
        $this->assertDatabaseMissing('historico_faturamentos', [
            'ano_mes' => date('Y') . "-" . date('m'),
        ]);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);

        $controller->atualizarFaturamento(500.00);

        $this->assertDatabaseHas('historico_faturamentos', [
            'ano_mes' => date('Y') . "-" . date('m'),
            'renda_bruta' => 500.00
        ]);
    }



    //////////////////

    public function test_cliente_crediario_deve_ser_incrementado_corretamente()
    {
        // Criação de um cliente fictício com o cpfOuCnpj
        $cliente = Clientes::create([
            'nome' => 'Cliente Teste',
            'cpfOuCnpj' => '12345678901', // Valor do cpfOuCnpj
            'telefone' => '12345678901', // Valor do telefone
            'email' => 'test@test.com', // Valor do email
            'endereco_completo' => 'Rua Teste, 123', // Valor do endereço
            'debitos' => 0.00, // Valor inicial dos débitos
        ]);
        // Chama a função para incrementar o crediário
        $valorCrediario = 50.00;
        $clienteId = $cliente->id;
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $controller->clienteCrediario($clienteId, $valorCrediario);
        // Verificar se o crediário foi incrementado corretamente
        $clienteAtualizado = Clientes::find($clienteId);
        $this->assertEquals(50.00, $clienteAtualizado->crediario); // O valor esperado é 100.00 + 50.00
    }



    public function test_cliente_crediario_nao_deve_ser_incrementado_se_cliente_nao_existir()
    {
        // Tentar incrementar o crediário de um cliente que não existe
        $clienteIdInexistente = 999; // ID que não existe
        $valorCrediario = 50.00;
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $controller->clienteCrediario($clienteIdInexistente, $valorCrediario);

        // Verificar que o cliente não existe
        $clienteInexistente = Clientes::find($clienteIdInexistente);
        $this->assertNull($clienteInexistente); // O cliente não deve existir
    }

    public function test_deve_criar_uma_nova_venda_com_dados_corretos()
    {
        // Dados simulados da requisição
        $request = new Request([
            'cliente_id' => 1,
            'metodo_pagamento' => 'Cartão',
            'valor_total' => 0,
            'data_venda' => now(),
        ]);

        // Executar o método
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = $controller->criarVenda($request);

        // Recuperar a venda criada


        // Verificações
        $this->assertInstanceOf(Vendas::class, $venda);
        $this->assertEquals(1, $venda->cliente_id);
        $this->assertEquals('Cartão', $venda->metodo_pagamento);
        $this->assertEquals(0, $venda->valor_total);
        $this->assertNotNull($venda->data_venda);
    }

    public function test_deve_persistir_venda_no_banco_de_dados()
    {
        $cliente = Clientes::factory()->create();
        $request = new Request([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Dinheiro'
        ]);

        // Executar o método
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = $controller->criarVenda($request);

        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Dinheiro',
            'valor_total' => 0
        ]);
    }

    public function test_data_venda_deve_ser_o_momento_da_criacao()
    {
        $cliente = Clientes::factory()->create();
        $request = new Request([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário'
        ]);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = $controller->criarVenda($request);

        $this->assertEqualsWithDelta(
            now()->timestamp,
            $venda->data_venda->timestamp,
            5 // Margem de 5 segundos para o teste
        );
    }

    public function test_valor_total_inicial_deve_ser_zero()
    {
        $cliente = Clientes::factory()->create();
        $request = new Request([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário'
        ]);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = $controller->criarVenda($request);

        $this->assertSame(0.0, (float) $venda->valor_total);
    }

    public function test_retorna_produto_quando_estoque_suficiente()
    {
        // Criar produto de teste
        $produto = Produtos::factory()->create([
            'nome' => 'Produto Teste',
            'modelo' => 'Modelo Teste',
            'marca' => 'Marca Teste',
            'unidade_medida' => 'Unidade Teste',
            'medida' => 10,
            'descricao' => 'Descrição Teste',
            'quantidade' => 10,
            'ultimo_fornecedor' => 'Fornecedor Teste',
            'preco_venda' => 100.00,
            'preco_compra' => 50.00,
            'desconto_maximo' => 80.00,
            'estado' => 'Ativo',
        ]);

        // Executar o método
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $resultado = $controller->validarProduto($produto->id, 5);

        // Verificações
        $this->assertInstanceOf(Produtos::class, $resultado);
        $this->assertEquals($produto->id, $resultado->id);
    }
    public function test_lanca_excecao_quando_estoque_insuficiente()
    {
        $produto = Produtos::factory()->create([
            'nome' => 'Produto Teste',
            'modelo' => 'Modelo Teste',
            'marca' => 'Marca Teste',
            'unidade_medida' => 'Unidade Teste',
            'medida' => 10,
            'descricao' => 'Descrição Teste',
            'quantidade' => 2,
            'ultimo_fornecedor' => 'Fornecedor Teste',
            'preco_venda' => 100.00,
            'preco_compra' => 50.00,
            'desconto_maximo' => 80.00,
            'estado' => 'Ativo',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Quantidade insuficiente no estoque para o produto ' . $produto->nome);
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $controller->ValidarProduto($produto->id, 5);
    }
    public function test_lanca_excecao_quando_produto_nao_existe()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $controller->ValidarProduto(999, 1);
    }
    public function test_aceita_quantidade_exatamente_igual_ao_estoque()
    {
        $produto = Produtos::factory()->create([
            'nome' => 'Produto Teste',
            'modelo' => 'Modelo Teste',
            'marca' => 'Marca Teste',
            'unidade_medida' => 'Unidade Teste',
            'medida' => 10,
            'descricao' => 'Descrição Teste',
            'quantidade' => 5,
            'ultimo_fornecedor' => 'Fornecedor Teste',
            'preco_venda' => 100.00,
            'preco_compra' => 50.00,
            'desconto_maximo' => 80.00,
            'estado' => 'Ativo',
        ]);

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $resultado = $controller->ValidarProduto($produto->id, 5);

        $this->assertEquals($produto->id, $resultado->id);
    }

    public function test_cria_item_venda_corretamente()
    {
        // Configurar ambiente
        $cliente = Clientes::factory()->create();
        $precoProduto = 25.50;
        $quantidade = 3;
        $produto = Produtos::factory()->create(['preco_venda' => $precoProduto]);
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id, 'valor_total' => $precoProduto * $quantidade]);

        // Executar método
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $subtotal = $controller->CriarItemVenda($venda, $produto, 3);

        // Verificações
        $this->assertDatabaseHas('itens_vendas', [
            'venda_id' => $venda->id,
            'produto_id' => $produto->id,
            'quantidade' => 3,
            'preco_unitario' => 25.50,
            'subtotal' => 76.50
        ]);

        $this->assertEquals(76.50, $subtotal);
    }
    public function test_calcula_subtotal_corretamente_para_diferentes_valores()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);

        // Cenário 1: Valores inteiros
        $produto1 = Produtos::factory()->create(['preco_venda' => 10]);
        $subtotal1 = $controller->CriarItemVenda($venda, $produto1, 5);
        $this->assertEquals(50, $subtotal1);

        // Cenário 2: Valores decimais
        $produto2 = Produtos::factory()->create(['preco_venda' => 7.99]);
        $subtotal2 = $controller->CriarItemVenda($venda, $produto2, 2);
        $this->assertEquals(15.98, $subtotal2);
    }

    public function test_relacionamentos_corretos_nos_itens()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produto = Produtos::factory()->create();

        $subtotal = $controller->CriarItemVenda($venda, $produto, 2);

        $item = Itens_venda::first();

        $this->assertTrue($item->venda->is($venda));
        $this->assertTrue($item->produto->is($produto));
    }

    public function test_cria_multiplos_itens_para_mesma_venda()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produto1 = Produtos::factory()->create();
        $produto2 = Produtos::factory()->create();

        $controller->CriarItemVenda($venda, $produto1, 1);
        $controller->CriarItemVenda($venda, $produto2, 2);

        $this->assertCount(2, $venda->itens);
        $this->assertEquals(2, Itens_venda::count());
    }

    public function test_decrementa_quantidade_do_produto_corretamente()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);

        $produto = Produtos::factory()->create(['quantidade' => 100]);

        $controller->AtualizarEstoque($produto, 5);

        $this->assertEquals(95, $produto->fresh()->quantidade);
    }

    public function test_cria_registro_estoque_com_dados_corretos()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        $produto = Produtos::factory()->create();

        $controller->AtualizarEstoque($produto, 3);

        $estoque = Estoque::first();

        $this->assertNotNull($estoque);
        $this->assertEquals($produto->id, $estoque->id_produto);
        $this->assertEquals(3, $estoque->quantidade);
        $this->assertEquals('Venda', $estoque->acao);
        $this->assertEquals(date('m'), $estoque->mes);
        $this->assertEquals(date('Y'), $estoque->ano);
        $this->assertEquals($user->id, $estoque->usuario);
    }

    public function test_usuario_nao_autenticado_deve_ter_usuario_null()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();

        $this->actingAs($user);
        $produto = Produtos::factory()->create();

        Auth::logout();
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);

        $controller->AtualizarEstoque($produto, 2);

        // Nunca deve chegar aqui porque a exceção será lançada antes
        $estoque = Estoque::first();
        $this->assertNull($estoque->usuario);
    }


    public function test_datas_devem_ser_do_momento_da_execucao()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);

        $produto = Produtos::factory()->create();
        $expectedMonth = date('m');
        $expectedYear = date('Y');

        $controller->AtualizarEstoque($produto, 1);

        $estoque = Estoque::first();
        $this->assertEquals($expectedMonth, $estoque->mes);
        $this->assertEquals($expectedYear, $estoque->ano);
    }

    public function test_decrementa_multiplas_vezes_corretamente()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);

        $produto = Produtos::factory()->create(['quantidade' => 50]);

        $controller->AtualizarEstoque($produto, 10);
        $controller->AtualizarEstoque($produto, 5);

        $this->assertEquals(35, $produto->fresh()->quantidade);
        $this->assertCount(2, Estoque::all());
    }

    public function test_define_total_venda_quando_valor_venda_null()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id, 'valor_total' => 0]);
        $request = new Request([]);
        $totalVenda = 150.75;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertEquals($totalVenda, $venda->fresh()->valor_total);
    }

    public function test_aplica_total_venda_quando_valor_venda_menor_que_desconto_maximo()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $request = new Request([
            'valor_venda' => 100,
            'desconto_maximo' => 120
        ]);
        $totalVenda = 150.75;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertEquals($totalVenda, $venda->fresh()->valor_total);
    }

    public function test_aplica_valor_venda_quando_maior_que_desconto_maximo()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $request = new Request([
            'valor_venda' => 180.5,
            'desconto_maximo' => 150
        ]);
        $totalVenda = 200;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertEquals(180.5, $venda->fresh()->valor_total);
    }

    public function test_lida_corretamente_com_valores_iguais()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $request = new Request([
            'valor_venda' => 150,
            'desconto_maximo' => 150
        ]);
        $totalVenda = 170.25;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertEquals(150, $venda->fresh()->valor_total);
    }


    public function test_persiste_dados_corretamente_no_banco()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $request = new Request([
            'valor_venda' => 99.99,
            'desconto_maximo' => 80
        ]);
        $totalVenda = 120.50;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'valor_total' => 99.99
        ]);
    }

    public function test_lida_com_desconto_maximo_null()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $request = new Request([
            'valor_venda' => 250,
            'desconto_maximo' => null
        ]);
        $totalVenda = 300;

        $controller->AtualizarTotalVenda($request, $venda, $totalVenda);

        $this->assertEquals(250, $venda->fresh()->valor_total);
    }

    public function test_deve_processar_crediario_quando_metodo_pagamento_correto()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);

        /** @var VendasController $mockController */
        $mockController = Mockery::mock(VendasController::class, [$metaServiceMock])->makePartial();

        $cliente = Clientes::factory()->create();
        $totalVenda = 500.75;
        $venda = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => $totalVenda,
        ]);

        // Mock do método clienteCrediario
        $mockController->shouldReceive('clienteCrediario')
            ->once()
            ->with($cliente->id, $totalVenda);

        // Chamando ProcessarPagamento no mock
        $mockController->ProcessarPagamento($venda, $totalVenda, $controller);

        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'crediario' => $totalVenda
        ]);
    }

    public function test_nao_deve_processar_crediario_para_metodos_diferentes()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $totalVenda = 300.50;
        $venda = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Pix',
            'crediario' => 0
        ]);


        // Mock para garantir que o método não é chamado
        $mock = $this->mock(VendasController::class, function (MockInterface $mock) {
            $mock->shouldNotReceive('clienteCrediario');
        });

        $controller->ProcessarPagamento($venda, $totalVenda, $mock);

        $this->assertDatabaseHas('vendas', [
            'id' => $venda->id,
            'crediario' => 0
        ]);
    }

    public function test_deve_atualizar_apenas_quando_crediario()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $totalVenda = 200.00;

        // Teste para Crediário
        $vendaCrediario = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => $totalVenda
        ]);

        $controller->ProcessarPagamento($vendaCrediario, $totalVenda);
        $crediarioPrimeiro = Clientes::find($cliente->id)->crediario;

        // Teste para Cartão
        $vendaCartao = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Cartão',
            'crediario' => 0
        ]);

        $controller->ProcessarPagamento($vendaCartao, $totalVenda);
        $crediarioSegundo = Clientes::find($cliente->id)->crediario;
        $this->assertEquals($crediarioPrimeiro, $crediarioSegundo);
    }

    public function test_deve_lancar_excecao_quando_crediario_for_nulo()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $totalVenda = 100;

        // Tentando criar uma venda com crediario NULL (deve falhar devido à restrição NOT NULL)
        Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => null // Isso deve gerar um erro SQL
        ]);
    }

    public function test_deve_deletar_venda_e_itens_quando_existir()
    {
        // Criar estrutura completa
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $itens = Itens_venda::factory(3)->create(['venda_id' => $venda->id]);

        // Executar método
        $controller->ReverterTransacao($venda);

        // Verificar exclusões
        $this->assertDatabaseMissing('vendas', ['id' => $venda->id]);
        $this->assertEquals(0, Itens_venda::where('venda_id', $venda->id)->count());
    }

    public function test_nao_deve_fazer_nada_quando_venda_null()
    {
        // Criar registros não relacionados
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = Vendas::factory()->create();
        Itens_venda::factory(2)->create(['venda_id' => $venda->id]);

        // Executar com null
        $controller->ReverterTransacao(null);

        // Verificar que nada foi excluído
        $this->assertDatabaseHas('vendas', ['id' => $venda->id]);
        $this->assertEquals(2, Itens_venda::count());
    }
    public function test_deve_manter_outras_vendas_ao_reverter_uma()
    {
        // Criar duas vendas
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda1 = Vendas::factory()->create();
        $venda2 = Vendas::factory()->create();
        Itens_venda::factory(2)->create(['venda_id' => $venda1->id]);
        Itens_venda::factory(3)->create(['venda_id' => $venda2->id]);

        // Reverter apenas a primeira
        $controller->ReverterTransacao($venda1);

        // Verificar exclusões seletivas
        $this->assertDatabaseMissing('vendas', ['id' => $venda1->id]);
        $this->assertDatabaseHas('vendas', ['id' => $venda2->id]);
        $this->assertEquals(0, Itens_venda::where('venda_id', $venda1->id)->count());
        $this->assertEquals(3, Itens_venda::where('venda_id', $venda2->id)->count());
    }

    public function test_deve_lidar_com_venda_sem_itens()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $venda = Vendas::factory()->create();

        $controller->ReverterTransacao($venda);

        $this->assertDatabaseMissing('vendas', ['id' => $venda->id]);
        $this->assertEquals(0, Itens_venda::count());
    }

    public function test_deve_processar_itens_validos_e_calcular_total()
    {
        // Configuração

        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produto1 = Produtos::factory()->create(['quantidade' => 10, 'preco_venda' => 20]);
        $produto2 = Produtos::factory()->create(['quantidade' => 5, 'preco_venda' => 30]);

        $request = new Request([
            'quantidades' => [
                $produto1->id => 3,
                $produto2->id => 2
            ]
        ]);

        // Execução
        $total = $controller->processarItensVenda($request, $venda);

        // Verificações
        $this->assertEquals(120, $total);
        $this->assertDatabaseCount('itens_vendas', 2);
        $this->assertEquals(7, $produto1->fresh()->quantidade);
        $this->assertEquals(3, $produto2->fresh()->quantidade);
    }

    public function test_deve_ignorar_quantidades_invalidas()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produto = Produtos::factory()->create(['quantidade' => 10]);

        $request = new Request([
            'quantidades' => [
                $produto->id => 0,
                999 => -5
            ]
        ]);

        $total = $controller->processarItensVenda($request, $venda);

        $this->assertEquals(0, $total);
        $this->assertDatabaseCount('itens_vendas', 0);
    }
    public function test_deve_lancar_excecao_para_produto_inexistente()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);

        $request = new Request([
            'quantidades' => [
                999 => 2
            ]
        ]);

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $controller->processarItensVenda($request, $venda);
    }

    public function test_deve_lancar_excecao_para_estoque_insuficiente()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produto = Produtos::factory()->create(['quantidade' => 5]);

        $request = new Request([
            'quantidades' => [
                $produto->id => 10
            ]
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Quantidade insuficiente no estoque');
        $controller->processarItensVenda($request, $venda);
    }

    public function test_deve_processar_multiplos_itens_com_precisao()
    {
        $metaServiceMock = Mockery::mock(MetaService::class);
        $controller = new VendasController($metaServiceMock);
        $user = Funcionarios::factory()->create();
        $this->actingAs($user);
        $cliente = Clientes::factory()->create();
        $venda = Vendas::factory()->create(['cliente_id' => $cliente->id]);
        $produtos = Produtos::factory(5)->create(['quantidade' => 100, 'preco_venda' => 10]);

        $quantidades = $produtos->mapWithKeys(fn($p) => [$p->id => 2])->toArray();
        $request = new Request(['quantidades' => $quantidades]);

        $total = $controller->processarItensVenda($request, $venda);

        $this->assertEquals(100, $total);
        $this->assertDatabaseCount('itens_vendas', 5);
        $this->assertEquals(98, $produtos->first()->fresh()->quantidade);
    }

    public function test_deve_chamar_todos_metodos_corretamente()
    {
        $totalVenda = 1500.75;

        // Mock do MetaService
        $metaServiceMock = Mockery::mock(MetaService::class);
        $metaServiceMock->shouldReceive('verificarSeExisteMeta')->once();
        $metaServiceMock->shouldReceive('cadastrarProgressoEmTodasMetasAbertas')->once()->with($totalVenda);

        // Mock do controlador com injeção do MetaService
        $controller = \Mockery::mock(VendasController::class, [$metaServiceMock])->makePartial();

        // Mockando o método do controlador
        $controller->shouldReceive('atualizarFaturamento')->once()->with($totalVenda);

        // Chamando o método que você está testando
        $controller->atualizarMetricas($totalVenda);
    }

}
