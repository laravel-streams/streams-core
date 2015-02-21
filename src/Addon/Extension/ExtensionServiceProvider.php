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

        if (app('Anomaly\Streams\Platform\Application\Application')->isInstalled()) {
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
            config('streams.extensions.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface',
            config('streams.extensions.repository')
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection'
        );

        $this->app->register('Anomaly\Streams\Platform\Addon\Extension\ExtensionEventProvider');
    }
}
