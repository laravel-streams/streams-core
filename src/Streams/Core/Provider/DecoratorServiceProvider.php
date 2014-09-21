<?php namespace Streams\Core\Provider;

use Streams\Core\Support\Decorator;
use Illuminate\Support\ServiceProvider;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.decorator',
            function () {
                return new Decorator();
            }
        );
    }
}
