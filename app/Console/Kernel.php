<?php

namespace App\Console;

use App\Console\Commands\CreateProduct;
use App\Console\Commands\UpdateProduct;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateProduct::class,
        UpdateProduct::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command(UpdateProduct::class)
            ->hourly();
    }
}
