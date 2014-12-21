<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormDoneEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\FormStartEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class BuildFormCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param BuildFormCommand $command
     */
    public function handle(BuildFormCommand $command)
    {
        $builder = $command->getBuilder();

        $input = compact('builder');

        // Set the form entry.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\SetFormEntryCommand', $input);

        // Fire an even to allow access to config before building.
        app('events')->fire('streams::form.start', new FormStartEvent($builder));

        // Build action objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Action\Command\BuildFormActionsCommand', $input);

        // Build button objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Button\Command\BuildFormButtonsCommand', $input);

        // Build section objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Section\Command\BuildFormSectionsCommand', $input);

        // Fire an event to allow hooking into the built table.
        app('events')->fire('streams::form.done', new FormDoneEvent($builder));
    }
}
