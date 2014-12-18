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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('streams.image', 'Anomaly\Streams\Platform\Image\Image');
    }
}
