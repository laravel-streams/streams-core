<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonHasRegistered;
use Laracasts\Commander\Events\EventListener;

class AddonListener extends EventListener
{
    public function whenApplicationIsBooting()
    {
        $this->addNamespaces();
    }

    public function whenAddonsHaveRegistered()
    {
        $this->registerAddonServiceProviders();
    }

    public function whenAddonHasRegistered(AddonHasRegistered $event)
    {
        $addon = $event->getAddon();

        $this->pushAddonToCollection($addon);
    }

    protected function addNamespaces()
    {
        foreach (config('streams::config.addon_types') as $type) {
            app('streams.addon.integrator')->register($type);
        }
    }

    protected function registerAddonServiceProviders()
    {
        foreach (config('streams::config.addon_types') as $type) {
            app('streams.addon.provider')->register($type);
        }
    }

    protected function pushAddonToCollection(Addon $addon)
    {
        app('streams.' . str_plural($addon->getType()))->put($addon->getSlug(), $addon);
    }
}
