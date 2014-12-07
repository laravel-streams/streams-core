<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class UnassignFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class UnassignFieldCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param UnassignFieldCommand          $command
     * @param StreamRepositoryInterface     $streams
     * @param FieldRepositoryInterface      $fields
     * @param AssignmentRepositoryInterface $assignments
     * @return mixed
     */
    public function handle(
        UnassignFieldCommand $command,
        StreamRepositoryInterface $streams,
        FieldRepositoryInterface $fields,
        AssignmentRepositoryInterface $assignments
    ) {
        $stream = $streams->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $fields->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        return $assignments->delete($stream, $field);
    }
}
 