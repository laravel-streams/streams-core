<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Notification\Command\TransmitNotification;

trait Transmitter
{
    /**
     * Transmit the notification.
     *
     * @param Notification $notification
     */
    public function transmit(Notification $notification)
    {
        $this->dispatch(new TransmitNotification($notification));
    }
}
