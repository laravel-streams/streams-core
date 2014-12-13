<?php namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('streams.image', 'Anomaly\Streams\Platform\Image\Image');
    }
}
