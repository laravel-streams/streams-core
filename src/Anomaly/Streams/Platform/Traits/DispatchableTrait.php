<?php namespace Anomaly\Streams\Platform\Traits;

/**
 * Class DispatchableTrait
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Traits
 */
trait DispatchableTrait
{

    /**
     * @param $event
     */
    public function dispatch($event)
    {
        app('events')->dispatch([$event]);
    }
}
 