<?php namespace Anomaly\Streams\Platform\Provider;

class ModelServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $loader = app('streams.loader');

        $loader->addPsr4('Anomaly\Streams\Platform\Model\\', base_path('storage/models/streams/' . APP_REF));

        return $loader->register();
    }
}
