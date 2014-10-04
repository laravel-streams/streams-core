<?php namespace Streams\Platform\Provider;

use Streams\Platform\Image\Image;
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
