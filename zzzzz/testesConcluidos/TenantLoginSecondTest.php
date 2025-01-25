<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\TenantDuskTestCase;

class TenantLoginSecondTest extends TenantDuskTestCase
{
    /**
     * A Dusk test example para login.
     */
    public function testLoginSecondInTenant(): void
    {
        $this->browse(function (Browser $browser) {
            // Definindo o subdomínio dinamicamente para o tenant específico (ex: 'ufop')
            $tenantSubdomain = 'supermercadomonlevade';  // Ajuste conforme necessário
            $baseUrl = "http://{$tenantSubdomain}.localhost:8000";
            // Alterando o subdomínio para o tenant específico
            $browser->visit("{$baseUrl}/login_second")
                ->assertSee('Token inválido.')
                ->screenshot('screenshot-tenant-login-second-test');
        });
    }
}
