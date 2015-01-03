<?php namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\ServiceProvider;

/**
 * Class ImageServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Image
 */
class ImageServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        app('twig')->addExtension(app('Anomaly\Streams\Platform\Image\ImagePlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Anomaly\Streams\Platform\Image\Image', 'Anomaly\Streams\Platform\Image\Image');
    }
}
