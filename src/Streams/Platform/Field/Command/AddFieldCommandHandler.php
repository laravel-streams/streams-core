<?php namespace Streams\Platform\Field\Command;

use Streams\Platform\Field\FieldModel;
use Laracasts\Commander\CommandHandler;

class AddFieldCommandHandler implements CommandHandler
{
    /**
     * The field model.
     *
     * @var \Streams\Platform\Field\FieldModel
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
    public function handle($command)
    {
        return $this->field->add(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getType(),
            $command->getRules(),
            $command->getSettings(),
            $command->getIsLocked()
        );
    }
}
 