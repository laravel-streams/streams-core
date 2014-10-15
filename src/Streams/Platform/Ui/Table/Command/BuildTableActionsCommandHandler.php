<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildTableActionsHandlerHandler implements HandlerInterface
{
    public function handle($command)
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
 