<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CreateTenant;
use App\Services\FaturamentoService;
class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateTenant::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $faturamentoService = app(FaturamentoService::class); // Instancia o serviço

            // Calcula vendas e atualiza o faturamento
            $valor_vendas_mes = $faturamentoService->calcularVendasDoMesAtual();
            $faturamentoService->atualizarFaturamentoMensal($valor_vendas_mes);
        })->monthlyOn(1, '00:00'); // Executa no dia 1 de cada mês à meia-noite

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
