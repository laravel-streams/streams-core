<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class StandardizeInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class StandardizeInputCommandHandler
{
    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param StandardizeInputCommand $command
     */
    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\StandardizeModelInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Field\Command\StandardizeFieldInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Action\Command\StandardizeActionInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Button\Command\StandardizeButtonInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Section\Command\StandardizeSectionInputCommand', $args);
    }
}
