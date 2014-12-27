<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

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

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();

        $this->registerPlugins();
    }

    /**
     * Register the tag listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.bootin',
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\ApplicationBootingListener'
        );
    }

    /**
     * Register the tag collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.plugins', new PluginCollection());
    }

    /**
     * Register all tag addons.
     */
    protected function registerPlugins()
    {
        $this->app->make('streams.addon.manager')->register('plugin');
    }
}
