<?php namespace Anomaly\Streams\Platform\Addon\Extension;

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

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCollection();

        $this->registerExtensions();
    }

    /**
     * Register the extension collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.extensions', new ExtensionCollection());
    }

    /**
     * Register all extension addons.
     */
    protected function registerExtensions()
    {
        $this->app->make('streams.addon.manager')->register('extension');
    }
}
