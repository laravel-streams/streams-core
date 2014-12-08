<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Laracasts\Commander\CommanderTrait;

class HandleFormCommandHandler
{

    use CommanderTrait;

    public function handle(HandleFormCommand $command)
    {
        $builder = $command->getBuilder();

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\HandleFormInputCommand', $args);

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\HandleFormAuthorizationCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\HandleFormValidationCommand', $args);

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\RunFormHandlerCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Action\Command\HandleFormActionCommand', $args);
    }
}
 