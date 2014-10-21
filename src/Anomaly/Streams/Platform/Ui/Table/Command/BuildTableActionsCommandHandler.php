<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableActionsCommandHandler
{
    public function handle(BuildTableActionsCommand $command)
    {
        $ui = $command->getUi();

        $actions = evaluate($ui->getActions(), [$ui]);

        foreach ($actions as &$action) {

            $title = 'test';

            $action = compact('title');

        }

        return $actions;
    }
}
 