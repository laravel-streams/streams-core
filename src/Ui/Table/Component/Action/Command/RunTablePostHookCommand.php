<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

/**
 * Class RunTablePostHookCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class RunTablePostHookCommand
{

    /**
     * The event object.
     *
     * @var TablePostEvent
     */
    protected $event;

    /**
     * Create a new RunTablePostHookCommand instance.
     *
     * @param TablePostEvent $event
     */
    public function __construct(TablePostEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Get the event object.
     *
     * @return TablePostEvent
     */
    public function getEvent()
    {
        return $this->event;
    }
}
