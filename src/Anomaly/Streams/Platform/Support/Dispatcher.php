<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Dispatcher
 *
 * This is a simple dispatch class that wraps
 * the Laravel dispatcher.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Dispatcher
{

    /**
     * Fire an array of events.
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {

            $eventName = $this->getEventName($event);

            app('events')->fire($eventName, $event);
        }
    }

    /**
     * Get the event name from a given event object.
     *
     * @param $event
     * @return mixed|string
     */
    protected function getEventName($event)
    {
        $event = str_replace('\\', '.', get_class($event));

        if (substr($event, -5) == 'Event') {

            $event = substr($event, 0, -5);
        }

        return $event;
    }
}
