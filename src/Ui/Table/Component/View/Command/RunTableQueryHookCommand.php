<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Class RunTableQueryHookCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class RunTableQueryHookCommand
{

    /**
     * The event object.
     *
     * @var TableQueryEvent
     */
    protected $event;

    /**
     * Create a new RunTableQueryHookCommand instance.
     *
     * @param TableQueryEvent $event
     */
    public function __construct(TableQueryEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Get the event object.
     *
     * @return TableQueryEvent
     */
    public function getEvent()
    {
        return $this->event;
    }
}
