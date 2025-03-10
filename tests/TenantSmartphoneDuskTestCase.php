<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class TenantSmartphoneDuskTestCase extends BaseTestCase
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
        //PARA NÃO ABRIR NO NAVEGADO
        /*
        $options = (new ChromeOptions)->addArguments(collect([
            '--disable-search-engine-choice-screen',
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());*/
        //PARA ABRIR O NAVEGADOR
        // /*
        $options = (new ChromeOptions)->addArguments(collect([
            '--disable-search-engine-choice-screen',
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            // Retire '--headless=new' para permitir visualização
            return $items->merge([
                '--disable-gpu',
                // '--headless=new', // Comente ou remova esta linha
            ]);
        })->all());
        //*/

        // Passando as opções para o driver
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        // Definir o subdomínio do tenant dinamicamente (ex: 'ufop')
        $tenantSubdomain = 'ufop';  // Subdomínio específico do tenant
        $baseUrl = "http://{$tenantSubdomain}.localhost";

        // Definir a URL base do aplicativo para o subdomínio correto
        config(['app.url' => $baseUrl]);

        // Criar o driver com as opções e capacidades
        return RemoteWebDriver::create(
            'http://localhost:9515', // WebDriver URL
            $capabilities
        );
    }
}
