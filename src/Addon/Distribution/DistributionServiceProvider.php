<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistributionCommand;
use Anomaly\Streams\Platform\Addon\Distribution\Command\RegisterDistributionsCommand;
use Anomaly\Streams\Platform\Addon\Distribution\Command\RegisterListenersCommand;
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
        $this->dispatch(new RegisterListenersCommand());
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
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection',
            'Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection'
        );
    }
}
