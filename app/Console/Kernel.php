<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function() {
            $userWhoFamous = DB::table('activities')
                                ->select('to_profile_id', DB::raw('COUNT(to_profile_id) as total_like'))
                                ->where('activity','like')
                                ->groupBy('to_profile_id')
                                ->havingRaw('COUNT(to_profile_id) > ?',[50])->get();

            Mail::to('admin@matchmakerapp.com')->send($userWhoFamous);
        })->daily();
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
