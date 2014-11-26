<?php namespace Anomaly\Streams\Platform\Provider;

class LogServiceProvider extends \Illuminate\Support\ServiceProvider
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
