<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class UnassignFieldCommandHandler
{

    use DispatchableTrait;

    public function handle(
        UnassignFieldCommand $command,
        StreamRepositoryInterface $streams,
        FieldRepositoryInterface $fields,
        AssignmentRepositoryInterface $assignments
    ) {
        $stream = $streams->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $fields->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        $assignment = $assignments->delete($stream->getKey(), $field->getKey());

        $this->dispatchEventsFor($assignment);

        return $assignment;
    }
}
 