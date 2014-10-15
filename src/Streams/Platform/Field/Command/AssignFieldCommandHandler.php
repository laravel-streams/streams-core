<?php namespace Streams\Platform\Field\Command;

use Streams\Platform\Field\FieldModel;
use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\HandlerInterface;
use Streams\Platform\Assignment\AssignmentModel;

class AssignFieldHandlerHandler implements HandlerInterface
{
    use DispatchableTrait;

    /**
     * The stream model.
     *
     * @var \Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * The field model.
     *
     * @var \Streams\Platform\Field\FieldModel
     */
    protected $field;

    /**
     * The assignment model.
     *
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * Create a new AssignFieldHandlerHandler instance.
     *
     * @param StreamModel     $stream
     * @param FieldModel      $field
     * @param AssignmentModel $assignment
     */
    function __construct(
        StreamModel $stream,
        FieldModel $field,
        AssignmentModel $assignment
    ) {
        $this->field      = $field;
        $this->stream     = $stream;
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

        $this->dispatchEventsFor($assignment);

        return $assignment;
    }
}
 