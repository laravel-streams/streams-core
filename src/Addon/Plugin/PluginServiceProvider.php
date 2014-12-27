<?php namespace Anomaly\Streams\Platform\Addon\Tag;

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

        $this->registerTags();
    }

    /**
     * Register the tag listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::plugins.registered',
            'Anomaly\Streams\Platform\Addon\Tag\Listener\PluginsRegisteredListener'
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
    protected function registerTags()
    {
        $this->app->make('streams.addon.manager')->register('plugin');
    }
}
