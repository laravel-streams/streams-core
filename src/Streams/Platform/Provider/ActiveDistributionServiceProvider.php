<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ActiveDistributionServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Setup the environment with the active distribution.
     */
    public function register()
    {
        $distribution = app('streams.distribution');

        // Setup namespace hints for a short namespace.
        app('view')->addNamespace('module', $distribution->getPath('resources/views'));
        app('streams.asset')->addNamespace('module', $distribution->getPath('resources'));
        app('streams.image')->addNamespace('module', $distribution->getPath('resources'));
        app('translator')->addNamespace('module', $distribution->getPath('resources/lang'));
    }
}
