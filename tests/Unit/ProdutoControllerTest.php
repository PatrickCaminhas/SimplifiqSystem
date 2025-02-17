<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Produtos;
use Mockery;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;

class ProdutoControllerTest extends TestCase
{
    public function test_nao_deve_cadastrar_categoria_sem_nome()
    {
        // Cria um request real
        $request = Request::create('/storeCategoria', 'POST', []);

        // Mock do controller
        $controller = new ProdutoController();

        // Executa a função storeCategoria
        $response = $controller->storeCategoria($request);

        // Verifica se a resposta é uma redireção com erro
        $this->assertNotEmpty($response->getSession()->get('error'));
    }

    public function test_pode_criar_produto()
    {
        // Mock do request
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->once();
        $request->shouldReceive('input')->with('nome')->andReturn('Teclado Mecânico');

        // Mock do modelo
        $produtoMock = Mockery::mock(Produtos::class);
        $produtoMock->shouldReceive('create')->once()->andReturnSelf();

        // Mock do controller
        $controller = new ProdutoController();

        // Executa a função store
        $response = $controller->store($request);

        // Verifica se a resposta tem sucesso
        $this->assertNotEmpty($response->getSession()->get('success'));
    }
}
