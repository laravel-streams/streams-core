<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\Decorator;
use Illuminate\Support\ServiceProvider;

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
