<?php namespace Streams\Core\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Core\Image\Image;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.image',
            function () {
                return new Image();
            }
        );
    }
}
