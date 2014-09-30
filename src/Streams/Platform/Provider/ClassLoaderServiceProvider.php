<?php namespace Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class ClassLoaderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->instance('streams.classloader', new ClassLoader());
    }
}
