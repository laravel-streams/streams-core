<?php namespace Anomaly\Streams\Platform\Notification\Message;

class MailMessage extends \Illuminate\Notifications\Messages\MailMessage
{
    /**
     * The message view.
     *
     * @var string
     */
    public $view = 'streams::notifications/email';
}
