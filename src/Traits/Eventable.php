<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Notification\Command\TransmitNotification;

trait Eventable
{
    /**
     * Dispatch the event.
     *
     * @param mixed $event
     */
    public function fire($event)
    {
        app('events')->dispatch($event);
    }
}
