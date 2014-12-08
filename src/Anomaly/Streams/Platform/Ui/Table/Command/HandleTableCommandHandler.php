<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

class HandleTableCommandHandler
{

    use CommanderTrait;

    public function handle(HandleTableCommand $command)
    {
        $builder = $command->getBuilder();

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\HandleTableActionCommand', $args);
    }
}
 