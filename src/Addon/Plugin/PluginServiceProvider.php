<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Addon\Plugin\Command\AddPluginsToTwig;
use Anomaly\Streams\Platform\Addon\Plugin\Command\RegisterListeners;
use Anomaly\Streams\Platform\Addon\Plugin\Command\RegisterPlugins;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class PluginServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Plugin
 */
class PluginServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterListeners());
        $this->dispatch(new RegisterPlugins());
        $this->dispatch(new AddPluginsToTwig());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
            'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection'
        );
    }
}
