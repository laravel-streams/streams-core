<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Log\Writer;

class Dispatcher
{
    /**
     * The Dispatcher instance.
     *
     * @var Dispatcher
     */
    protected $event;

    /**
     * Create a new Dispatcher instance.
     *
     * @param Dispatcher $event
     * @param Writer     $log
     */
    function __construct(\Illuminate\Events\Dispatcher $event)
    {
        $this->event = $event;
    }

    /**
     * Dispatch all raised events.
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {

            echo $eventName = $this->getEventName($event).'<br>';

            $this->event->fire($eventName, $event);

        }
    }

    /**
     * Make the fired event name look more object-oriented.
     *
     * @param $event
     * @return string
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
