<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Field\Command\CreateField;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class CreateFieldHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class CreateFieldHandler
{

    /**
     * The fields repository.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new CreateFieldHandler instance.
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
     * @param  CreateField $command
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(CreateField $command)
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
