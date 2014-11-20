<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class DeleteFieldCommandHandler
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
    public function handle(DeleteFieldCommand $command)
    {
        $field = $this->field->remove(
            $command->getNamespace(),
            $command->getSlug()
        );

        if ($field) {
            $this->dispatchEventsFor($field);

            return $field;
        }

        return false;
    }
}
 