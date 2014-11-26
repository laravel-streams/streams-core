<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Asset\Image;

class ImageServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register image utility.
     */
    public function register()
    {
        $this->app->instance('streams.image', new Image());
    }
}
