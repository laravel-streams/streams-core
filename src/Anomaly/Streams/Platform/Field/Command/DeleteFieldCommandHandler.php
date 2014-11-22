<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class DeleteFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class DeleteFieldCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param DeleteFieldCommand       $command
     * @param FieldRepositoryInterface $fields
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(DeleteFieldCommand $command, FieldRepositoryInterface $fields)
    {
        return $fields->delete(
            $command->getNamespace(),
            $command->getSlug()
        );
    }
}
 