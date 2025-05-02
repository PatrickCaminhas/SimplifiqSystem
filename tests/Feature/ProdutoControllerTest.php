<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\ProdutoController;
use App\Models\Produtos;
use App\Models\Produtos_categoria;
use App\Models\Itens_venda;
use App\Models\Vendas;
use App\Models\Clientes;
use App\Models\Cotacoes;
use App\Models\Itens_cotacoes;
use App\Models\Fornecedores;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_categoria_com_sucesso()
    {
        $controller = new ProdutoController();

        $request = new \Illuminate\Http\Request();
        $request->replace(['nome' => 'Eletrônicos']);
        $controller->storeCategoria($request);


        $this->assertDatabaseHas('produtos_categoria', ['nome' => 'Eletrônicos']);
    }

    public function test_criar_categoria_duplicada()
    {
        Produtos_categoria::create(['nome' => 'Eletrônicos']);
        $controller = new ProdutoController();

        $request = new \Illuminate\Http\Request();
        $request->replace(['nome' => 'Eletrônicos']);
        $controller->storeCategoria($request);

        $this->assertDatabaseHas('produtos_categoria', ['nome' => 'Eletrônicos']);
    }

    // Teste para store produto
    public function test_criar_produto_com_sucesso()
    {
        $categoria = Produtos_categoria::create(['nome' => 'Eletrônicos']);
        $controller = new ProdutoController();
        $request = new \Illuminate\Http\Request();
        $request->replace( [
            'nome' => 'Notebook',
            'marca' => 'Dell',
            'modelo' => 'XPS 15',
            'categoria' => $categoria->id,
            'unidade_medida' => 'Unidade',
            'medida' => '1',
            'descricao' => 'Teste'
        ]);
        $controller->store($request);
        $this->assertDatabaseHas('produtos', [
            'nome' => 'Notebook',
            'marca' => 'Dell',
            'modelo' => 'XPS 15',
            'categoria_id' => $categoria->id,
            'unidade_medida' => 'Unidade',
            'medida' => '1',
            'descricao' => 'Teste'
        ]);

    }

    // Teste para search produtos
    public function test_busca_produtos_ativos()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create(['estado' => 'Ativo']);

        $request = new Request(['term' => $produto->nome]);
        $response = $controller->search($request);

        $this->assertStringContainsString($produto->nome, $response->getContent());
    }

    // Teste para maiores compradores
    public function test_maiores_compradores()
    {
        $controller = new ProdutoController();
        $cliente = Clientes::factory()->create();
        $produto = Produtos::factory()->create();

        Vendas::factory()->create(['cliente_id' => $cliente->id, 'data_venda' => now()->subMonth()])
            ->itens()->create([
                'produto_id' => $produto->id,
                'quantidade' => 5,
                'preco_unitario' => 100,
                'subtotal' => 500
            ]);

        $response = $controller->buscarMaioresCompradores($produto->id);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($cliente->nome, $responseData[0]['nome']);
        $this->assertEquals(5, $responseData[0]['total_comprado']);
    }

    // Teste para maiores fornecedores
    public function test_maiores_fornecedores_cotacoes()
    {
        $controller = new ProdutoController();
        $fornecedor = Fornecedores::factory()->create();
        $produto = Produtos::factory()->create();
        $cotacao = Cotacoes::factory()->create(['data_cotacao' => now()->subMonth()]);

        Itens_cotacoes::factory()->count(3)->create([
            'id_cotacao' => $cotacao->id,
            'produto_id' => $produto->id,
            'fornecedor_id' => $fornecedor->id
        ]);

        $response = $controller->buscarMaioresFornecedoresCotacoes($produto->id);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($fornecedor->nome, $responseData[0]['fornecedor_nome']);
        $this->assertEquals(3, $responseData[0]['total_cotacoes']);
    }

    // Teste para variação de preço
    public function test_variacao_preco_produto()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create();
        $venda = Vendas::factory()->create(['data_venda' => now()->subMonth()]);

        Itens_venda::factory()->create([
            'venda_id' => $venda->id,
            'produto_id' => $produto->id,
            'preco_unitario' => 150.00
        ]);

        $response = $controller->buscarVariacaoPrecoProduto($produto->id);
        $responseData = json_decode($response->getContent(), true);

        $expectedDate = now()->subMonth()->format('Y/m');
        $this->assertEquals($expectedDate, $responseData[0]['mes_ano']);
        $this->assertEquals(150.00, $responseData[0]['preco_unitario']);
    }

    // Teste para atualizar preços
    public function test_atualizar_precos_com_sucesso()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create([
            'preco_compra' => 100,
            'preco_venda' => 150,
            'desconto_maximo' => 120
        ]);

        $request = new Request([
            'id' => $produto->id,
            'preco_venda' => 160,
            'desconto_maximo' => 130
        ]);

        $response = $controller->atualizarPrecos($request);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'preco_venda' => 160,
            'desconto_maximo' => 130
        ]);
    }

    public function test_atualizar_precos_com_desconto_invalido()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create([
            'preco_compra' => 100,
            'preco_venda' => 150
        ]);

        $request = new Request([
            'id' => $produto->id,
            'preco_venda' => 160,
            'desconto_maximo' => 90 // Menor que preço de compra
        ]);

        $response = $controller->atualizarPrecos($request);

        $this->assertStringContainsString('O desconto máximo não pode ser menor que o preço de compra', session()->get('error'));
    }

    // Teste para atualizar produto via API
    public function test_atualizar_produto_api_sucesso()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create();
        $request = new \Illuminate\Http\Request();

        $request->replace( [
            'nome' => $produto->nome,
            'marca' => $produto->marca,
            'modelo' => $produto->modelo,
            'categoria_id' => 1,
            'unidade_medida' => $produto->unidade_medida,
            'medida' => $produto->medida,
            'descricao' => $produto->descricao,
        ]);
        $response = $controller->atualizarProdutoApi($request, $produto->id);

        $responseData = json_decode($response->getContent(), true);

        $this->assertTrue($responseData['success']);


        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => $produto->nome,
        ]);
    }

    // Teste para desativar produto
    public function test_desativar_produto()
    {
        $controller = new ProdutoController();
        $produto = Produtos::factory()->create(['estado' => 'Ativo']);

        $response = $controller->alterarEstadoProduto($produto->id);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'estado' => 'Inativo'
        ]);
    }






    ///


    // Testes para views
public function test_create_view()
{
    $controller = new ProdutoController();
    $response = $controller->create();
    $this->assertStringContainsString('cadastroDeProduto', $response->name());
}

public function test_create_atualizar_dados_view()
{
    $produto = Produtos::factory()->create();
    $controller = new ProdutoController();
    $response = $controller->createAtualizarDadosProduto($produto->id);
    $this->assertStringContainsString('alterarDadosProduto', $response->name());
}

// Teste para atualização de dados do produto
public function test_atualizar_dados_produto_sucesso()
{
    $produto = Produtos::factory()->create();
    $categoria = Produtos_categoria::factory()->create();

    $request = new Request([
        'id' => $produto->id,
        'nome' => 'Novo Nome',
        'marca' => 'Nova Marca',
        'categoria' => $categoria->id,
        'unidade_medida' => 'Kilograma'
    ]);

    $controller = new ProdutoController();
    $response = $controller->atualizarDadosProduto($request);

    $this->assertDatabaseHas('produtos', [
        'id' => $produto->id,
        'nome' => 'Novo Nome',
        'categoria_id' => $categoria->id
    ]);
}

// Testes para API de categorias
public function test_listar_categorias_api()
{
    Produtos_categoria::factory()->count(3)->create();
    $controller = new ProdutoController();
    $response = $controller->listarTodasCategoriasAPI();

    $this->assertCount(3, $response->getData());
    $this->assertEquals(200, $response->getStatusCode());
}

public function test_search_categoria_nao_encontrada()
{
    $controller = new ProdutoController();
    $response = $controller->searchCategoria(999);

    $this->assertEquals(404, $response->getStatusCode());
    $this->assertJsonStringEqualsJsonString(
        '{"error":true,"message":"Categoria não encontrada"}',
        $response->getContent()
    );
}

// Testes para atualização de preços via API
public function test_atualizar_precos_api_sucesso()
{
    $produto = Produtos::factory()->create(['preco_venda' => 100]);
    $controller = new ProdutoController();

    $request = new Request([
        'preco_venda' => 150,
        'desconto_maximo' => 130
    ]);

    $response = $controller->atualizarPrecosAPI($request, $produto->id);
    $responseData = json_decode($response->getContent(), true);

    $this->assertTrue($responseData['success']);
    $this->assertEquals(150, $produto->fresh()->preco_venda);
}

public function test_atualizar_precos_api_produto_inexistente()
{
    $controller = new ProdutoController();
    $request = new Request(['preco_venda' => 150]);
    $response = $controller->atualizarPrecosAPI($request, 999);

    $this->assertEquals(404, $response->getStatusCode());
}

// Testes para cenários de erro
public function test_buscar_maiores_compradores_sem_dados()
{
    $produto = Produtos::factory()->create();
    $controller = new ProdutoController();
    $response = $controller->buscarMaioresCompradores($produto->id);

    $this->assertEquals(404, $response->getStatusCode());
    $this->assertJsonStringEqualsJsonString(
        '{"error":true,"message":"Nenhuma compra encontrada para esse produto"}',
        $response->getContent()
    );
}

public function test_buscar_variacao_preco_sem_dados()
{
    $produto = Produtos::factory()->create();
    $controller = new ProdutoController();
    $response = $controller->buscarVariacaoPrecoProduto($produto->id);

    $this->assertEmpty($response->getData());
}

// Teste para validação de atualização de produto
public function test_atualizar_produto_api_validacao()
{
    $produto = Produtos::factory()->create();
    $controller = new ProdutoController();

    $request = new Request([
        'categoria_id' => 999, // Categoria inexistente
        'medida' => -5 // Valor inválido
    ]);

    $response = $controller->atualizarProdutoApi($request, $produto->id);
    $responseData = json_decode($response->getContent(), true);

    $this->assertEquals(422, $response->getStatusCode());
    $this->assertArrayHasKey('errors', $responseData);
}
}
