<?php namespace Anomaly\Streams\Platform\Addon\Listener;

use Anomaly\Streams\Platform\Addon\AddonIntegrator;
use Anomaly\Streams\Platform\Addon\AddonProvider;

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
     * The addon provider.
     *
     * @var AddonProvider
     */
    protected $provider;

    /**
     * The addon integrator.
     *
     * @var AddonIntegrator
     */
    protected $integrator;

    /**
     * Create a new ApplicationBootingListener instance.
     *
     * @param AddonProvider   $provider
     * @param AddonIntegrator $integrator
     */
    function __construct(AddonProvider $provider, AddonIntegrator $integrator)
    {
        $this->provider   = $provider;
        $this->integrator = $integrator;
    }

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
            $this->integrator->register($type);
        }
    }

    /**
     * Register all addon service providers.
     */
    protected function registerAddonServiceProviders()
    {
        foreach (config('streams::config.addon_types') as $type) {
            $this->provider->register($type);
        }
    }
}
