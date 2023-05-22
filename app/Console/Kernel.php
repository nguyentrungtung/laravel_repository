<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Custom\CreateCrud;
use App\Console\Commands\Custom\CreateRoute;
use App\Console\Commands\Custom\CreateModel;
use App\Console\Commands\Custom\CreateController;
use App\Console\Commands\Custom\CreateMigration;
use App\Console\Commands\Custom\CreateViewEdit;
use App\Console\Commands\Custom\CreateViewIndex;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }
    protected $commands = [
        CreateCrud::class,
        CreateRoute::class,
        CreateModel::class,
        CreateController::class,
        CreateMigration::class,
        CreateViewEdit::class,
        CreateViewIndex::class,
    ];
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
