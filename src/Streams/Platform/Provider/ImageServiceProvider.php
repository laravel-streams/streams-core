<?php namespace Streams\Platform\Provider;

use Streams\Platform\Image\Image;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerImageClass();
    }

    /**
     * Register the image class for Streams.
     */
    protected function registerImageClass()
    {
        $this->app->singleton(
            'streams.image',
            function () {
                return new Image();
            }
        );
    }
}
