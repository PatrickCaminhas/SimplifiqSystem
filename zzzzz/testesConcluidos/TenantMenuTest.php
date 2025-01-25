<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\TenantDuskTestCase;

class TenantMenuTest extends TenantDuskTestCase
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
                ->waitForLocation('/dashboard') // Aguarda redirecionamento
                ->assertSee('Simplifiq') // Confirma que o dashboard carregou
                ->waitFor('#menuButtom')
                ->press('#menuButtom') // Abre o menu offcanvas
                ->waitFor('#buttomMenuProdutos') // Aguarda o menu "Produtos"
                ->press('#buttomMenuProdutos')
                ->press('#buttomMenuVendas')
                ->press('#buttomMenuClientes')
                ->press('#buttomMenuFornecedores')
                ->press('#buttomMenuEmpresa')
                ->mouseover('#buttomMenuSimples') // Aguarda o menu "Produtos"
                ->screenshot('screenshot-menu-test');

        });
    }
}
