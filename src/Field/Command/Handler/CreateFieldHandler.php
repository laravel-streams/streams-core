<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Field\Command\CreateField;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
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
     * The field repository.
     *
     * @var FieldRepositoryInterface
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
     * @return FieldInterface
     */
    public function handle(CreateField $command)
    {
        return $this->fields->create();
    }
}
