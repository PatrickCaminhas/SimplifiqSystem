<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\TenantDuskTestCase;
use Illuminate\Support\Facades\Log;

class TenantLoginTest extends TenantDuskTestCase
{
    /**
     * A Dusk test example para login.
     */
    public function testLoginInTenant(): void
    {

        $this->browse(function (Browser $browser) {
            // Definindo o subdomínio dinamicamente para o tenant específico (ex: 'ufop')
            $tenantSubdomain = 'supermercadomonlevade';  // Ajuste conforme necessário
            $baseUrl = "http://{$tenantSubdomain}.localhost";
            // Alterando o subdomínio para o tenant específico
            $browser->visit("{$baseUrl}/login_second")
                ->type('email', 'patrickcaminhas@gmail.com') // Preenche o campo de email
                ->type('senha', '12345678') // Preenche o campo de senha
                ->press('Acesse') // Clica no botão de login
                ->assertPathIs('/dashboard') // Verifica se foi redirecionado para o dashboard
                ->screenshot('screenshot-tenant-login-test')
                ->storeConsoleLog('login-page');

        });

    }
}
