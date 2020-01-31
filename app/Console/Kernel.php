<?php

namespace App\Console;

use App\Jobs\FetchUserPlanning;
use App\Jobs\SynchronizeGoogleCalendar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use Webpatser\Uuid\Uuid;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        foreach(User::all() as $user){
            if($user->account){
                $key = (String) Uuid::generate(4);
                $schedule->job((new FetchUserPlanning($user, $key))->chain([
                    new SynchronizeGoogleCalendar($user)
                ]))->daily()->withoutOverlapping();
            }
        }
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
