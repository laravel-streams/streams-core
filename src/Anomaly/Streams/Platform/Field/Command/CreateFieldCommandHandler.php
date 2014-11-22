<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class CreateFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class CreateFieldCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param CreateFieldCommand       $command
     * @param FieldRepositoryInterface $fields
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(CreateFieldCommand $command, FieldRepositoryInterface $fields)
    {
        return $fields->create(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getType(),
            $command->getRules(),
            $command->getConfig(),
            $command->getIsLocked()
        );
    }
}
 