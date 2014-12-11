<?php namespace Anomaly\Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;

class ModelServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $loader = new ClassLoader();

        $loader->addPsr4('Anomaly\Streams\Platform\Model\\', base_path('storage/models/streams/' . app('streams.application')->getReference()));

        $loader->register();
    }
}
