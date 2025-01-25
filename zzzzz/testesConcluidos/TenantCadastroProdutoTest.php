<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\TenantDuskTestCase;

class TenantCadastroProdutoTest extends TenantDuskTestCase
{
    /**
     * A Dusk test example para login.
     */
    public function testCadastroProduto(): void
    {
        $this->browse(function (Browser $browser) {
           // Definindo o subdomínio dinamicamente para o tenant específico (ex: 'ufop')
           $tenantSubdomain = 'supermercadomonlevade';  // Ajuste conforme necessário
           $baseUrl = "http://{$tenantSubdomain}.localhost:8000";
           // Alterando o subdomínio para o tenant específico
           $browser->visit("{$baseUrl}/login")
               ->type('email', 'patrickcaminhas@gmail.com')
               ->type('senha', '12345678')
               ->press('Acesse')
               ->waitForLocation("{$baseUrl}/dashboard"); // Aguarda redirecionamento para o dashboard

           // Navega até o cadastro de produto
           $browser->visit("{$baseUrl}/cadastroproduto")
               ->type('#nomeproduto', 'Produto Teste')
               ->type('#modeloproduto', 'Modelo Teste')
               ->type('#marcaproduto', 'Marca Teste')
               ->select('#categoriaproduto', 'categoria-1')
               ->select('#unidadeproduto', 'unidade')
               ->type('#medidaproduto', '5')
               ->type('#descricao', 'Teste de produto')
               ->press('#buttomCadastrar') // Acessa o botão de cadastro
               ->assertSee('Produto cadastrado com sucesso!')
               ->screenshot('screenshot-tenant-cadastro-produto-test');
        });
    }
}
