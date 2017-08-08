<?php

namespace App\Console;

use DB;
use Log;
use App\Console\Commands\SendEmails;
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
        SendEmails::class, // 注册命令
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
	
	$schedule->call(function () {
	    Log::info('schedule done.');
	})->everyMinute()->appendOutputTo(storage_path() . '/logs/scheduling.log');

	$schedule->call(function () {
    	    Log::info('every day 10:30');
	})->dailyAt('10:30');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
