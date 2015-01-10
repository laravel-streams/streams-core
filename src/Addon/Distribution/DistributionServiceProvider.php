<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistributionCommand;
use Anomaly\Streams\Platform\Addon\Distribution\Command\RegisterDistributionsCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;
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

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterDistributionsCommand());
        $this->dispatch(new DetectActiveDistributionCommand());

        $this->app->make('twig')->addExtension(app('Anomaly\Streams\Platform\Addon\Distribution\DistributionPlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();
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
}
