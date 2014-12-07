<?php namespace Anomaly\Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;

class LoaderServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the class loader used in Streams.
     */
    public function register()
    {
        $this->app->instance('streams.loader', new ClassLoader());
    }
}
