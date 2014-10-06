<?php namespace Streams\Platform\Traits;

trait DispatchableTrait
{
    public function dispatchEventsFor($object)
    {
        $this->getDispatcher()->dispatch($object->releaseEvents());
    }

    public function getDispatcher()
    {
        return app('Streams\Platform\Support\EventDispatcher');
    }
}
 