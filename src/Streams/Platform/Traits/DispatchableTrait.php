<?php  namespace Streams\Platform\Traits;

trait DispatchableTrait
{

    /**
     * The Dispatcher instance.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Dispatch all events for an entity.
     *
     * @param object $entity
     */
    public function dispatchEventsFor($entity)
    {
        return $this->getDispatcher()->dispatch($entity->releaseEvents());
    }

    /**
     * Set the dispatcher instance.
     *
     * @param mixed $dispatcher
     */
    public function setDispatcher($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get the event dispatcher.
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher ? : app('Streams\Platform\Support\EventDispatcher');
    }
}
