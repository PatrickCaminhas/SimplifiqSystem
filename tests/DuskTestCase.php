<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        // Definir as opções para o Chrome
        $options = (new ChromeOptions)->addArguments(collect([
            '--disable-search-engine-choice-screen',  // Desativa tela de escolha de motor de busca
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080', // Se 'shouldStartMaximized' for verdadeiro, maximiza a janela
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu', // Desabilita GPU quando em modo headless
                '--headless=new', // Habilita o modo headless
            ]);
        })->all());

        // Passando as opções para o driver
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        // URL do WebDriver
        $baseUrl = env('APP_URL', 'http://tenant.localhost');
        // Criar o driver com as opções e capacidades
        return RemoteWebDriver::create(
            'http://localhost:9515', // WebDriver URL
            $capabilities
        );
    }
}
