<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class HandleTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param HandleTableCommand $command
     */
    public function handle(HandleTableCommand $command)
    {
        $builder = $command->getBuilder();

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\HandleTableActionCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\HandleTableSortingCommand', $args);
    }
}
