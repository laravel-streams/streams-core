<?php namespace Anomaly\Streams\Platform\Traits;

trait DispatchableTrait
{

    public function dispatch($event)
    {
        $this->getDispatcher()->dispatch([$event]);
    }

    public function dispatchEventsFor($object)
    {
        $this->getDispatcher()->dispatch($object->releaseEvents());
    }

    public function getDispatcher()
    {
        return app('Anomaly\Streams\Platform\Support\Dispatcher');
    }
}
 