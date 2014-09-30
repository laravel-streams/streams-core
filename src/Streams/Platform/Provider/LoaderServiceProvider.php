<?php namespace Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class LoaderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->instance('streams.loader', new ClassLoader());
    }
}
