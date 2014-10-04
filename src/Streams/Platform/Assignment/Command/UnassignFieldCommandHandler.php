<?php namespace Streams\Platform\Assignment\Command;

use Streams\Platform\Field\FieldModel;
use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\CommandInterface;
use Streams\Platform\Assignment\AssignmentModel;

class UnassignFieldCommandHandler implements CommandInterface
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
     * Create a new UnassignFieldCommandHandler instance.
     *
     * @param StreamModel $stream
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
        $stream = $this->stream->findByNamespaceAndSlug(
            $command->getNamespace(),
            $command->getStream()
        );

        $field = $this->field->findByNamespaceAndSlug(
            $command->getNamespace(),
            $command->getField()
        );


        if ($stream and $field) {
            if ($assignment = $this->assignment->remove($stream->getKey(), $field->getKey())) {
                $this->dispatchEventsFor($assignment);

                return $assignment;
            }
        }

        return false;
    }
}
 