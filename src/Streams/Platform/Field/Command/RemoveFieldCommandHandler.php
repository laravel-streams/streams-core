<?php namespace Streams\Platform\Field\Command;

use Streams\Platform\Field\FieldModel;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\EventDispatcher;

class RemoveFieldCommandHandler implements CommandHandler
{
    /**
     * The event dispatcher.
     *
     * @var \Laracasts\Commander\Events\EventDispatcher
     */
    protected $dispatcher;

    /**
     * The field model.
     *
     * @var \Streams\Platform\Field\Model\FieldModel
     */
    protected $field;

    /**
     * Create a new InstallFieldCommandHandler instance.
     *
     * @param EventDispatcher $dispatcher
     * @param FieldModel      $field
     */
    function __construct(EventDispatcher $dispatcher, FieldModel $field)
    {
        $this->field      = $field;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle($command)
    {
        $field = $this->field->remove(
            $command->getNamespace(),
            $command->getSlug()
        );

        if ($field) {
            $this->dispatcher->dispatch($field->releaseEvents());

            return $field;
        }

        return false;
    }
}
 