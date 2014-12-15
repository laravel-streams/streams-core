<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormBuildingEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\FormBuiltEvent;
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

        app('events')->fire('streams::form.building', new FormBuildingEvent($builder));

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormEntryCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormValidationCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Action\Command\LoadFormActionsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Button\Command\LoadFormButtonsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Section\Command\LoadFormSectionsCommand', $args);

        app('events')->fire('streams::form.built', new FormBuiltEvent($builder));
    }
}
