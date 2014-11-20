<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use ReflectionClass;

/**
 * Class Listener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
abstract class Listener
{

    use CommandableTrait;

    /**
     * Handle the event through the container.
     *
     * @param $event
     * @return null
     */
    public function handle($event)
    {
        $eventName = $this->getEventName($event);

        if ($this->listenerIsRegistered($eventName)) {

            return app()->call(get_class($this) . '@when' . $eventName, compact('event'));
        }

        return null;
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