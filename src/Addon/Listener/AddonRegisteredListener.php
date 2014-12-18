<?php namespace Anomaly\Streams\Platform\Addon\Listener;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonRegisteredEvent;

/**
 * Class AddonRegisteredListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class AddonRegisteredListener
{

    /**
     * When an addon is registered put it
     * in it's respective collection.
     *
     * @param AddonRegisteredEvent $event
     */
    public function handle(AddonRegisteredEvent $event)
    {
        $addon = $event->getAddon();

        $this->pushAddonToCollection($addon);
    }

    /**
     * Put an addon in it's respective collection.
     *
     * @param Addon $addon
     */
    protected function pushAddonToCollection(Addon $addon)
    {
        app('streams.' . str_plural($addon->getType()))->put($addon->getSlug(), $addon);
    }
}
