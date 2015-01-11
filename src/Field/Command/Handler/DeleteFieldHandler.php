<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Field\Command\DeleteField;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class DeleteFieldHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class DeleteFieldHandler
{

    /**
     * The field repository.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new DeleteFieldHandler instance.
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
     * @param  DeleteField $command
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface
     */
    public function handle(DeleteField $command)
    {
        return $this->fields->delete(
            $command->getNamespace(),
            $command->getSlug()
        );
    }
}
