<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\RegisteredEvent;
use Anomaly\Streams\Platform\Support\Listener;

/**
 * Class AddonListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonListener extends Listener
{

    /**
     * Push the addon to it's collection after it is registered.
     *
     * @param RegisteredEvent $event
     */
    public function whenRegistered(RegisteredEvent $event)
    {
        $addon = $event->getAddon();

        $collection = 'streams.' . str_plural($addon->getType());

        app($collection)->push($addon);
    }
}
 