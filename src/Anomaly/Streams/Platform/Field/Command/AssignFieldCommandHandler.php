<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;

class AssignFieldCommandHandler
{
    use DispatchableTrait;

    /**
     * The stream model.
     *
     * @var \Anomaly\Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * The field model.
     *
     * @var \Anomaly\Streams\Platform\Field\FieldModel
     */
    protected $field;

    /**
     * The assignment model.
     *
     * @var \Anomaly\Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * Create a new AssignFieldCommandHandler instance.
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
    public function handle(AssignFieldCommand $command)
    {
        $stream = $this->stream->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $this->field->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        $assignment = $this->assignment->add(
            $command->getSortOrder(),
            $stream->getKey(),
            $field->getKey(),
            $command->getLabel(),
            $command->getPlaceholder(),
            $command->getInstructions(),
            $command->getIsUnique(),
            $command->getIsRequired(),
            $command->getIsTranslatable(),
            $command->getIsRevisionable()
        );

        $this->dispatchEventsFor($assignment);

        return $assignment;
    }
}
 