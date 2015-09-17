<?php

namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Command\UnassignField;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class UnassignFieldHandler.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class UnassignFieldHandler
{
    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new UnassignFieldHandler instance.
     *
     * @param AssignmentRepositoryInterface $assignments
     * @param Dispatcher                    $events
     */
    public function __construct(AssignmentRepositoryInterface $assignments, Dispatcher $events)
    {
        $this->events      = $events;
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param  UnassignField $command
     */
    public function handle(UnassignField $command)
    {
        if ($assignment = $this->assignments->findByStreamAndField($command->getStream(), $command->getField())) {
            $this->assignments->delete($assignment);
        }
    }
}
