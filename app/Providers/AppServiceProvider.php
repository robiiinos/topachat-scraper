<?php

namespace App\Providers;

use App\Repositories\Contracts\TopAchatRepositoryContract;
use App\Repositories\TopAchatRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TopAchatRepositoryContract::class,
            TopAchatRepository::class
        );
    }
}
