<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class AddFieldCommandHandler
{

    use DispatchableTrait;

    /**
     * The field model.
     *
     * @var \Anomaly\Streams\Platform\Field\FieldModel
     */
    protected $field;

    /**
     * Create a new InstallFieldCommandHandler instance.
     *
     * @param FieldModel $field
     */
    function __construct(FieldModel $field)
    {
        $this->field = $field;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle(AddFieldCommand $command)
    {
        $field = $this->field->add(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getType(),
            $command->getRules(),
            $command->getConfig(),
            $command->getIsLocked()
        );

        $this->dispatchEventsFor($field);

        return $field;
    }
}
 