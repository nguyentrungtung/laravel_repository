<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceBindProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        /* Services */
        // $this->app->singleton(
        //     \App\Services\AlbumServiceInterface::class,
        //     \App\Services\Production\AlbumService::class
        // );
    }
}
