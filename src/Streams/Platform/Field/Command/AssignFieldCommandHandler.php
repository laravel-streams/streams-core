<?php namespace Streams\Platform\Field\Command;

use Streams\Platform\Field\FieldModel;
use Laracasts\Commander\CommandHandler;
use Streams\Platform\Stream\StreamModel;
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
     * The stream model.
     *
     * @var \Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * The field model.
     *
     * @var \Streams\Platform\Field\Model\FieldModel
     */
    protected $field;

    /**
     * The assignment model.
     *
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * Create a new AssignFieldCommandHandler instance.
     *
     * @param EventDispatcher $dispatcher
     * @param StreamModel     $stream
     * @param FieldModel      $field
     * @param AssignmentModel $assignment
     */
    function __construct(
        EventDispatcher $dispatcher,
        StreamModel $stream,
        FieldModel $field,
        AssignmentModel $assignment
    ) {
        $this->field      = $field;
        $this->stream     = $stream;
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
        $stream = $this->stream->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $this->field->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        $assignment = $this->assignment->add(
            $command->getSortOrder(),
            $stream->getKey(),
            $field->getKey(),
            $command->getName(),
            $command->getInstructions(),
            $command->getSettings(),
            $command->getRules(),
            $command->getIsTranslatable(),
            $command->getIsRevisionable()
        );

        //$this->raise();

        return $assignment;
    }
}
 