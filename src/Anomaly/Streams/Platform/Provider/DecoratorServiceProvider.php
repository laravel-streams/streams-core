<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Anomaly\Streams\Platform\Support\Decorator;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the decorator service.
     */
    public function register()
    {
        $this->app->instance('streams.decorator', new Decorator());
    }
}
