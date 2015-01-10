<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveActionCommand;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtonsCommand;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFieldsCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildFormCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormCommandHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param BuildFormCommand $command
     */
    public function handle(BuildFormCommand $command)
    {
        $builder = $command->getBuilder();

        /**
         * Resolve and set the form model and stream.
         */
        $this->dispatch(new SetFormModelCommand($builder));
        $this->dispatch(new SetFormStreamCommand($builder));
        $this->dispatch(new SetFormEntryCommand($builder));

        /*
         * Build form fields.
         */
        $this->dispatch(new BuildFieldsCommand($builder));

        /**
         * Build form actions and flag active.
         */
        $this->dispatch(new BuildActionsCommand($builder));
        $this->dispatch(new SetActiveActionCommand($builder));

        /**
         * Build form buttons.
         */
        $this->dispatch(new BuildButtonsCommand($builder));
    }
}
