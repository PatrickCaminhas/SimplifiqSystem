<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testPaginaInicial(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Bem-vindo ao Simplifiq')
                    ->screenshot('screenshot-test'); // Captura a tela e salva com o nome 'screenshot-test.png'

        });
    }
}
