<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormIsBuilding;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasBuilt;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;

class BuildFormCommandHandler
{
    use CommanderTrait;
    use DispatchableTrait;

    public function handle(BuildFormCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $form->raise(new FormIsBuilding($builder));

        $this->dispatchEventsFor($form);

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormEntryCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormValidationCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Action\Command\LoadFormActionsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Button\Command\LoadFormButtonsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Section\Command\LoadFormSectionsCommand', $args);

        $form->raise(new FormWasBuilt($builder));

        $this->dispatchEventsFor($form);
    }
}
