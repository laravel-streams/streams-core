<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Listener;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;
use Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionWasRegistered;
use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Illuminate\Events\Dispatcher;

/**
 * Class FireDistributionWasRegisteredEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Listener
 */
class FireDistributionWasRegisteredEvent
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new FireDistributionWasRegisteredEvent instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the event.
     *
     * @param AddonWasRegistered $event
     */
    public function handle(AddonWasRegistered $event)
    {
        $addon = $event->getAddon();

        if ($addon instanceof Distribution) {
            $this->dispatcher->fire(new DistributionWasRegistered($addon));
        }
    }
}
