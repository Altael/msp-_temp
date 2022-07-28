<?php

namespace App\Console;

use App\Console\Commands\BotCommands;
use App\Console\Commands\FindUsersTelegramNickname;
use App\Console\Commands\Geolocation\FindUsersDistrictArea;
use App\Console\Commands\Import;
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
        FindUsersDistrictArea::class,
        Import::class,
        BotCommands::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->command(FindUsersDistrictArea::class)->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('users:unit-placement')->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('users:unit-placement --full')->daily()->withoutOverlapping();
        $schedule->command('fill-countries')->daily()->withoutOverlapping();*/

        $schedule->command('audit-clear')->daily()->withoutOverlapping();
        $schedule->command('users:give-unit-status')->everySixHours()->withoutOverlapping();
        $schedule->command('users:find-telegram-nickname --full')->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('users:deprecate-roles')->everyFifteenMinutes()->withoutOverlapping();
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
