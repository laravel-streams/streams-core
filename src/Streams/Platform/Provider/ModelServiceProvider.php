<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $loader = app('streams.loader');

        $loader->addPsr4('Streams\Platform\Model\\', base_path('storage/models/streams/' . APP_REF));

        return $loader->register();
    }
}
