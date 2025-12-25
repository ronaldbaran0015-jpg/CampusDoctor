<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $routeMiddleWare = [
        'routeAccess' => \App\Http\Middleware\RouteAccess::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('appointments:mark-missed')->everyMinute();
    }
}