<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class HandleFormCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param HandleFormCommand $command
     */
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
