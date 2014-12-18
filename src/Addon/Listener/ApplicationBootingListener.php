<?php namespace Anomaly\Streams\Platform\Addon\Listener;

/**
 * Class ApplicationBootingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class ApplicationBootingListener
{

    /**
     * When the application is booting add all
     * the addon's various utility namespaces.
     */
    public function handle()
    {
        $this->addNamespaces();

        /**
         * This MUST occur absolutely last in
         * the boot process for Streams.
         *
         * Otherwise:
         * - Namespaces (above) can't set because the translator is deferred
         */
        $this->registerAddonServiceProviders();
    }

    /**
     * Add namespaces for all addons.
     */
    protected function addNamespaces()
    {
        foreach (config('streams::config.addon_types') as $type) {
            app('streams.addon.integrator')->register($type);
        }
    }

    /**
     * Register all addon service providers.
     */
    protected function registerAddonServiceProviders()
    {
        foreach (config('streams::config.addon_types') as $type) {
            app('streams.addon.provider')->register($type);
        }
    }
}
