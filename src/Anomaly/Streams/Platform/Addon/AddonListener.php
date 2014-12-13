<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonHasRegistered;
use Anomaly\Streams\Platform\Application\Event\ApplicationIsBooting;
use Laracasts\Commander\Events\EventListener;

class AddonListener extends EventListener
{
    public function whenApplicationIsBooting(ApplicationIsBooting $event)
    {
        $this->addNamespaces();
    }

    public function whenAddonHasRegistered(AddonHasRegistered $event)
    {
        $addon = $event->getAddon();

        $this->pushAddonToCollection($addon);
    }

    protected function addNamespaces()
    {
        foreach (config('streams::config.addon_types') as $type) {
            foreach (app(str_plural($type)) as $addon) {
                $this->addNamespace($addon);
            }
        }
    }

    protected function addNamespace(Addon $addon)
    {
        app('view')->addNamespace($addon->getAbstract(), $addon->getPath('resources/views'));
        app('config')->addNamespace($addon->getAbstract(), $addon->getPath('resources/config'));
        app('translator')->addNamespace($addon->getAbstract(), $addon->getPath('resources/lang'));

        app('streams.asset')->addNamespace($addon->getAbstract(), $addon->getPath('resources'));
        app('streams.image')->addNamespace($addon->getAbstract(), $addon->getPath('resources'));
    }

    protected function pushAddonToCollection(Addon $addon)
    {
        app(str_plural($addon->getType()))->put($addon->getSlug(), $addon);
    }
}
