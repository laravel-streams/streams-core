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

    public function whenRegistered(RegisteredEvent $event)
    {
    }
}
 