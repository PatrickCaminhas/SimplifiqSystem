<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CreateTenant;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateTenant::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Defina os comandos agendados
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}