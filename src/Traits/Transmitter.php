<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Notifications\Notification;
use Anomaly\Streams\Platform\Notification\Event\Transmission;

trait Transmitter
{
    /**
     * Transmit the notification.
     *
     * @param Notification $notification
     */
    public function transmit(Notification $notification)
    {
        app('events')->fire(new Transmission($notification));
    }
}
