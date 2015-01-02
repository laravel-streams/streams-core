<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

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
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Command\SetFormModelCommand',
            compact('builder')
        );
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Command\SetFormStreamCommand',
            compact('builder')
        );
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Command\SetFormEntryCommand',
            compact('builder')
        );

        /*
         * Build form fields.
         */
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFieldsCommand',
            compact('builder')
        );

        /**
         * Build form actions and flag active.
         */

        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActionsCommand',
            compact('builder')
        );
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveActionCommand',
            compact('builder')
        );

        /**
         * Build form buttons.
         */
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtonsCommand',
            compact('builder')
        );
    }
}
