<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    protected $name;

    public function __construct($name = null)
    {
        $this->name = $name;
    }

    public function run()
    {
        // Use o nome fornecido ao invés de um nome pré-estabelecido
        $name = $this->name;

        // Verifica se um nome foi fornecido
        if (!$name) {
            $this->command->info('Nenhum nome de tenant fornecido.');
            return;
        }

        // Cria o tenant com o nome fornecido
        $tenant = Tenant::create(['id' => $name]);
        $tenant->domains()->create(['domain' => "{$name}.localhost"]);

        // Exibe mensagem de sucesso
        $this->command->info("Tenant {$name} foi criado com sucesso com o domínio {$name}.localhost");
    }
}
