<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class DeleteFieldCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class DeleteFieldCommandHandler
{

    /**
     * The field repository.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new DeleteFieldCommandHandler instance.
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
     * @param  DeleteFieldCommand $command
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(DeleteFieldCommand $command)
    {
        return $this->fields->delete(
            $command->getNamespace(),
            $command->getSlug()
        );
    }
}
