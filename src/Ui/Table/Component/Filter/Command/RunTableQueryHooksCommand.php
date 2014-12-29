<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Class RunTableQueryHooksCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class RunTableQueryHooksCommand
{

    /**
     * The event object.
     *
     * @var TableQueryEvent
     */
    protected $event;

    /**
     * Create a new RunTableQueryHooksCommand instance.
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
