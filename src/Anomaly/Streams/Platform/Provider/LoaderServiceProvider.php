<?php namespace Anomaly\Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class LoaderServiceProvider extends ServiceProvider
{
    /**
     * Register the class loader used in Streams.
     */
    public function register()
    {
        $this->app->instance('streams.loader', new ClassLoader());
    }
}
