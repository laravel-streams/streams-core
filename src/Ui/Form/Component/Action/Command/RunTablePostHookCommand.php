<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;

/**
 * Class RunFormPostHookCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
 */
class RunFormPostHookCommand
{

    /**
     * The event object.
     *
     * @var FormPostEvent
     */
    protected $event;

    /**
     * Create a new RunFormPostHookCommand instance.
     *
     * @param FormPostEvent $event
     */
    public function __construct(FormPostEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Get the event object.
     *
     * @return FormPostEvent
     */
    public function getEvent()
    {
        return $this->event;
    }
}
