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
        // TODO: get the slug from somewhere better than hard code
        $distribution = app('streams.distributions')->findBySlug('base');

        $this->app->singleton(
            'streams.distribution',
            function () use ($distribution) {

                return $distribution;

            }
        );
    }
}
