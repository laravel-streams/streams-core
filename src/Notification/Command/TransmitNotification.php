<?php namespace Anomaly\Streams\Platform\Notification\Command;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Anomaly\Streams\Platform\Notification\Event\Transmission;

class TransmitNotification
{
    /**
     * The notification instance.
     *
     * @var Notification
     */
    protected $notification;

    /**
     * Create a new TransmitNotification instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Handle the command.
     *
     * @param Dispatcher $events
     */
    public function handle(Dispatcher $events)
    {
        $events->fire(new Transmission($this->notification));
    }
}
