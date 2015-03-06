<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Illuminate\Events\Dispatcher;

/**
 * Class AddonDispatcher
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonDispatcher
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new AddonDispatcher instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Disperse the AddonWasRegistered event.
     *
     * @param Addon $addon
     */
    public function addonWasRegistered(Addon $addon)
    {
        $this->dispatcher->fire(new AddonWasRegistered($addon));

        $type = studly_case($addon->getType());

        $event = 'Anomaly\Streams\Platform\Addon\\' . $type . '\Event\\' . $type . 'WasRegistered';

        $this->dispatcher->fire(new $event($addon));
    }
}
