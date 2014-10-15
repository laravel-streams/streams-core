<?php namespace Streams\Platform\Support;

use ReflectionClass;

abstract class Listener
{
    /**
     * Handle the event
     *
     * @param $event
     * @return mixed
     */
    public function handle($event)
    {
        $eventName = $this->getEventName($event);

        if ($this->listenerIsRegistered($eventName)) {
            return call_user_func([$this, 'when' . $eventName], $event);
        }
    }

    /**
     * Figure out what the name of the class is.
     *
     * @param $event
     * @return string
     */
    protected function getEventName($event)
    {
        $name = (new ReflectionClass($event))->getShortName();

        if (substr($name, -5) == 'Event') {
            $name = substr($name, 0, -5);
        }

        return $name;
    }

    /**
     * Determine if a method in the subclass is registered
     * for this particular event.
     *
     * @param $eventName
     * @return bool
     */
    protected function listenerIsRegistered($eventName)
    {
        $method = "when{$eventName}";

        if (substr($method, -5) == 'Event') {
            $method = substr($method, 0, -5);
        }

        return method_exists($this, $method);
    }

}