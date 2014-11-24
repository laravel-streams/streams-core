<?php namespace Anomaly\Streams\Platform\Provider;

class ExceptionServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register any error handlers
     *
     * @return void
     */
    public function boot()
    {
        $whoops = new \Whoops\Run;

        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        $whoops->register();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
 