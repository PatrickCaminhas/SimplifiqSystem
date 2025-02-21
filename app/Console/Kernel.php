<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Services\FaturamentoService;
use App\Console\Commands\CheckCrediarioCommand;
class Kernel extends ConsoleKernel
{
    protected $commands = [
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $faturamentoService = app(FaturamentoService::class); // Instancia o serviço

            // Calcula vendas e atualiza o faturamento
            $valor_vendas_mes = $faturamentoService->calcularVendasDoMesAtual();
            $faturamentoService->atualizarFaturamentoMensal($valor_vendas_mes);
        })->monthlyOn(1, '00:00'); // Executa no dia 1 de cada mês à meia-noite
        // Tarefa para verificar o status de vendas a crediário diariamente às 00:00
        $schedule->command('crediario:check')->dailyAt('00:00');

    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
