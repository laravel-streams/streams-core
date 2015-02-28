<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Command\AssignField;

/**
 * Class AssignFieldHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldHandler
{

    /**
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new AssignFieldHandler instance.
     *
     * @param AssignmentRepositoryInterface $assignments
     */
    function __construct(AssignmentRepositoryInterface $assignments)
    {
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param AssignField $command
     * @return AssignmentInterface
     */
    public function handle(AssignField $command)
    {
        return $this->assignments->create($command->getStream(), $command->getField(), $command->getAttributes());
    }
}
