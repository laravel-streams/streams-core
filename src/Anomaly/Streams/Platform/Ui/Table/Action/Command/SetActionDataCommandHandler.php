<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;

class SetActionDataCommandHandler
{
    public function handle(SetActionDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $actions = [];

        foreach ($table->getActions() as $action) {
            if ($action instanceof ActionInterface) {
                $actions[] = $action->viewData();
            }
        }

        $table->putData('actions', $actions);
    }
}
