<?php

namespace App\Console;

use App\Console\Commands\GenarateInvoice;
use App\Console\Commands\MakeRepositoryCommand;
use App\Console\Commands\MonthlyGrowth;
use App\Console\Commands\UpdateJournals;
use App\Console\Commands\UpdatePermission;
use App\Growth;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdatePermission::class,
        GenarateInvoice::class,
        MakeRepositoryCommand::class,
        UpdateJournals::class,
        MonthlyGrowth::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("invoice:rent")->monthlyOn(27 ,'13.00');
        $schedule->command("journal:update")->monthlyOn( 27,'13.00');
        $schedule->command("monthly:growth")->monthlyOn( 1);

        // $schedule->command('inspire')
        //          ->hourly();
    }

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
