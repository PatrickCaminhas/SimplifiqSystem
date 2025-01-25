<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CadastroTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testPaginaCadastro(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cadastro')
                    ->assertSee('Nós somos mais que uma empresa')
                    ->screenshot('screenshot-cadastro-test');
        });
    }
}
