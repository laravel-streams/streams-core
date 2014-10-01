<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $loader      = app('streams.loader');
        $application = app('streams.application');

        $loader->addPsr4(
            'Streams\Platform\Model\\',
            base_path('storage/models/streams/' . $application->getReference())
        );

        return $loader->register();
    }
}
