<?php namespace Anomaly\Streams\Platform\Provider;

class ActiveDistributionServiceProvider extends \Illuminate\Support\ServiceProvider
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
        if ($distribution = app('streams.distributions')->active()) {

            // Setup namespace hints for a short namespace.
            app('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
            app('streams.asset')->addNamespace('distribution', $distribution->getPath('resources'));
            app('streams.image')->addNamespace('distribution', $distribution->getPath('resources'));
            //app('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));
        }
    }
}
