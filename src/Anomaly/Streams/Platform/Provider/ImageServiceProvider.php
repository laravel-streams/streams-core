<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Asset\Image;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register image utility.
     */
    public function register()
    {
        $this->app->instance('streams.image', new Image());
    }
}
