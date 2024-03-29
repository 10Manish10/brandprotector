<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

use App\Models\Cron;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\AmazonCrawl',
        'App\Console\Commands\DataFetch',
        'App\Console\Commands\ScrapperStatus',
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('dataset:update')->cron('*/1 * * * *');
        $schedule->command('data:fetch')->cron('*/2 * * * *');
        // $schedule->command('inspire')->hourly();
        // $crons = Cron::all();
        // foreach ($crons as $cron) {
        //     $schedule->command($cron->command)->name($cron->name)->cron($cron->schedule);
        // }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
