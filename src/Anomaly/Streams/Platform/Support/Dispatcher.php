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
     * Laravel's dispatcher object.
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected $event;

    /**
     * Create a new Dispatcher object.
     *
     * @param \Illuminate\Events\Dispatcher $event
     */
    function __construct(\Illuminate\Events\Dispatcher $event)
    {
        $this->event = $event;
    }

    /**
     * Fire an array of events.
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {

            $eventName = $this->getEventName($event);

            $this->event->fire($eventName, $event);
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
