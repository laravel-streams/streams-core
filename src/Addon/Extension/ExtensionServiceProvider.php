<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Command\RegisterExtensions;
use Anomaly\Streams\Platform\Addon\Extension\Command\RegisterListeners;
use Anomaly\Streams\Platform\Addon\Extension\Command\SetExtensionStates;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class ExtensionServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterExtensions());

        if (env('INSTALLED')) {
            $this->dispatch(new SetExtensionStates());
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionRepository'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection',
            'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection'
        );

        $this->app->register('Anomaly\Streams\Platform\Addon\Extension\ExtensionEventProvider');
    }
}
