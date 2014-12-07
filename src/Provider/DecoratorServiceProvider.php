<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\Decorator;

class DecoratorServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the decorator service.
     */
    public function register()
    {
        $this->app->instance('streams.decorator', new Decorator());
    }
}
