<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\Registered;
use Laracasts\Commander\CommanderTrait;
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
    use CommanderTrait;

    public function whenStreamsIsBooting()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Command\AddAddonNamespaceHintsCommand');
    }

    /**
     * Push the addon to it's collection after it is registered.
     *
     * @param Registered $event
     */
    public function whenRegistered(Registered $event)
    {
        $addon = $event->getAddon();

        $collection = 'streams.' . str_plural($addon->getType());

        app($collection)->push($addon);
    }
}
