<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class HandleTableSortingCommandHandler
{

    public function handle(HandleTableSortingCommand $command)
    {
        $builder = $command->getBuilder();
    }
}
 