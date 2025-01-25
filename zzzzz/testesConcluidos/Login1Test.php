<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Login1Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testLoginGlobal(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Nós somos mais que uma empresa')
                    ->screenshot('screenshot-login-test');
        });
    }
}
