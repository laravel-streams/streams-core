<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Configure the application's logging facilities.
     *
     * @return void
     */
    public function boot()
    {
        app('log')->useFiles(storage_path() . '/logs/laravel.log');
    }
}
