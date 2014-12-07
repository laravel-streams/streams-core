<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class AssignFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle(
        AssignFieldCommand $command,
        StreamRepositoryInterface $streams,
        FieldRepositoryInterface $fields,
        AssignmentRepositoryInterface $assignments
    ) {
        $stream = $streams->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $fields->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        return $assignments->create(
            $stream,
            $field,
            $command->getLabel(),
            $command->getPlaceholder(),
            $command->getInstructions(),
            $command->getIsUnique(),
            $command->getIsRequired(),
            $command->getIsTranslatable()
        );
    }
}
 