<?php namespace Streams\Platform\Provider;

use Streams\Platform\Support\Decorator;
use Illuminate\Support\ServiceProvider;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerDecoratorClass();
    }

    /**
     * Register the decorator class for Streams.
     */
    protected function registerDecoratorClass()
    {
        $this->app->singleton(
            'streams.decorator',
            function () {
                return new Decorator();
            }
        );
    }
}
