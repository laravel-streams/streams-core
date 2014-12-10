<?php namespace Anomaly\Streams\Platform\Provider;

class ExceptionServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $whoops = new \Whoops\Run;

        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        $whoops->register();
    }
}
 