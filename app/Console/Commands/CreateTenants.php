<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Funcionarios;

class CreateTenant extends Command
{
    // O nome e a assinatura do comando no terminal, com um argumento
    protected $signature = 'tenant:create {name}';

    // A descrição do comando
    protected $description = 'Cria um tenant com o nome especificado e um domínio correspondente';

    // O método handle é onde a lógica do comando será implementada
    public function handle()
    {
        // Obtém o argumento 'name' do comando
        $name = $this->argument('name');

        // Cria o tenant com o nome fornecido
        $tenant = Tenant::create(['id' => $name]);
        $tenant->domains()->create(['domain' => "{$name}.localhost"]);

        // Exibe mensagem de sucesso
        $this->info("Tenant {$name} foi criado com sucesso com o domínio {$name}.localhost");
        
    }
}
