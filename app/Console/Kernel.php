<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Получение данных о заправках из интеграции
        $schedule->command('e1card:transaction')->everyFourMinutes();
        // Получение данных о заправках из интеграции
        $schedule->command('monopoly:transaction')->everyFiveMinutes();

        // Получение токена для e1card
        $schedule->command('e1card:auth')->everyFifteenMinutes();
        // Получение токена для Монополии
        $schedule->command('monopoly:auth')->everyFifteenMinutes();

        // переодическое удаление старых записей
        //$schedule->command('model:prune')->daily();
        $schedule->command('model:prune')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
