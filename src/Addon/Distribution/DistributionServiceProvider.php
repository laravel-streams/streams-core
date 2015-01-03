<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Illuminate\Support\ServiceProvider;

/**
 * Class DistributionServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();

        $this->registerDistributions();
    }

    /**
     * Register the distribution listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Addon\Distribution\Listener\ApplicationBootingListener'
        );
    }

    /**
     * Register the distribution collection.
     */
    protected function registerCollection()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection',
            'Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection'
        );
    }

    /**
     * Register all distribution addons.
     */
    protected function registerDistributions()
    {
        $this->app->make('Anomaly\Streams\Platform\Addon\AddonManager')->register('distribution');
    }
}
