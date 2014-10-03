<?php namespace Streams\Platform\Traits;

trait EventableTrait
{
    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * Raise a new event
     *
     * @param $event
     */
    public function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * Return and reset all pending events
     *
     * @return array
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;

        $this->pendingEvents = [];

        return $events;
    }
}
