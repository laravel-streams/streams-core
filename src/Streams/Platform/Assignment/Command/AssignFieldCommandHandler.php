<?php namespace Streams\Platform\Assignment\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\EventDispatcher;
use Streams\Platform\Assignment\AssignmentModel;

class AssignFieldCommandHandler implements CommandHandler
{
    /**
     * The event dispatcher.
     *
     * @var \Laracasts\Commander\Events\EventDispatcher
     */
    protected $dispatcher;

    /**
     * The assignment model.
     *
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * Create a new InstallStreamCommandHandler instance.
     *
     * @param EventDispatcher $dispatcher
     * @param AssignmentModel $assignment
     */
    function __construct(EventDispatcher $dispatcher, AssignmentModel $assignment)
    {
        $this->assignment = $assignment;
        $this->dispatcher = $dispatcher;
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

        $this->dispatcher->dispatch($assignment->releaseEvents());

        return $assignment;
    }
}
 