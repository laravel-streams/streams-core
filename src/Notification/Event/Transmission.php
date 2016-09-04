<?php namespace Anomaly\Streams\Platform\Notification\Event;

use Illuminate\Notifications\Notification;

class Transmission
{
    /**
     * The notification instance.
     *
     * @var Notification
     */
    protected $notification;

    /**
     * Create a new NotificationHasBeenDispatched instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification.
     *
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }
}
