<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;
use App\Models\Produtos_categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_nao_pode_cadastrar_categoria_sem_nome()
    {
        $response = $this->post(route('categorias.store'), []);
        $response->assertSessionHasErrors('nome');
    }

    public function test_nao_pode_cadastrar_categoria_duplicada()
    {
        Produtos_categoria::factory()->create(['nome' => 'Eletrônicos']);

        $response = $this->post(route('categorias.store'), ['nome' => 'Eletrônicos']);

        $response->assertSessionHas('error', 'Categoria já cadastrada.');
    }

    public function test_pode_cadastrar_categoria()
    {
        $response = $this->post(route('categorias.store'), ['nome' => 'Móveis']);

        $response->assertSessionHas('success', 'Categoria cadastrada com sucesso!');
        $this->assertDatabaseHas('produtos_categorias', ['nome' => 'Móveis']);
    }

    public function test_nao_pode_cadastrar_produto_sem_nome()
    {
        $response = $this->post(route('produtos.store'), []);
        $response->assertSessionHasErrors('nome');
    }

    public function test_pode_cadastrar_produto()
    {
        $categoria = Produtos_categoria::factory()->create();

        $response = $this->post(route('produtos.store'), [
            'nome' => 'Teclado Mecânico',
            'marca' => 'Logitech',
            'modelo' => 'G Pro X',
            'categoria' => $categoria->id,
            'unidade_medida' => 'un',
            'medida' => '1',
            'descricao' => 'Teclado mecânico RGB',
        ]);

        $response->assertSessionHas('success', 'Produto cadastrado com sucesso!');
        $this->assertDatabaseHas('produtos', ['nome' => 'Teclado Mecânico']);
    }
    public function test_pode_atualizar_dados_produto()
    {
        $produto = \App\Models\Produtos::factory()->create(['nome' => 'Mouse']);

        $response = $this->put(route('produtos.update', $produto->id), [
            'id' => $produto->id,
            'nome' => 'Mouse Gamer',
            'marca' => 'Razer',
        ]);

        $response->assertSessionHas('success', 'Produto atualizado com sucesso!');
        $this->assertDatabaseHas('produtos', ['nome' => 'Mouse Gamer']);
    }
    public function test_pode_buscar_produto_por_nome()
    {
        \App\Models\Produtos::factory()->create(['nome' => 'Mouse']);

        $response = $this->getJson(route('produtos.search', ['term' => 'Mouse']));

        $response->assertJsonFragment(['nome' => 'Mouse']);
    }

}
