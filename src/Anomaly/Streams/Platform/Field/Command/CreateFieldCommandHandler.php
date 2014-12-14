<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Laracasts\Commander\Events\DispatchableTrait;

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
     * The fields repository.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new CreateFieldCommandHandler instance.
     *
     * @param FieldRepositoryInterface $fields
     */
    public function __construct(FieldRepositoryInterface $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Handle the command.
     *
     * @param CreateFieldCommand $command
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(CreateFieldCommand $command)
    {
        return $this->fields->create(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getType(),
            $command->getRules(),
            $command->getConfig(),
            $command->isLocked()
        );
    }
}
