<?php namespace Streams\Platform\Assignment\Command;

use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\CommandInterface;
use Streams\Platform\Assignment\AssignmentModel;

class AssignFieldCommandHandler implements CommandInterface
{
    use DispatchableTrait;

    /**
     * The assignment model.
     *
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * Create a new InstallStreamCommandHandler instance.
     *
     * @param AssignmentModel $assignment
     */
    function __construct(AssignmentModel $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle($command)
    {
        $assignment = $this->assignment->assign(
            $command->getSortOrder(),
            $command->getStreamId(),
            $command->getFieldId(),
            $command->getName(),
            $command->getInstructions(),
            $command->getSettings(),
            $command->getRules(),
            $command->getIsTranslatable(),
            $command->getIsRevisionable()
        );

        $this->dispatchEventsFor($assignment);

        return $assignment;
    }
}
 