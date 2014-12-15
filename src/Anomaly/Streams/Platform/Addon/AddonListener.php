<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonHasRegistered;
use Laracasts\Commander\Events\EventListener;

/**
 * Class AddonListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonListener extends EventListener
{

    /**
     * Fired when the ApplicationServiceProvider starts booting.
     */
    public function whenApplicationIsBooting()
    {
        $this->addNamespaces();

        /**
         * This MUST occur absolutely last in
         * the boot process for Streams.
         *
         * Otherwise:
         * - Namespaces won't be set
         */
        $this->registerAddonServiceProviders();
    }

    /**
     * Fired when an addon has registered.
     *
     * @param AddonHasRegistered $event
     */
    public function whenAddonHasRegistered(AddonHasRegistered $event)
    {
        $addon = $event->getAddon();

        $this->pushAddonToCollection($addon);
    }

    /**
     * Add namespaces for all addon.
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

    /**
     * Push an addon to it's collection.
     *
     * @param Addon $addon
     */
    protected function pushAddonToCollection(Addon $addon)
    {
        app('streams.' . str_plural($addon->getType()))->put($addon->getSlug(), $addon);
    }
}
