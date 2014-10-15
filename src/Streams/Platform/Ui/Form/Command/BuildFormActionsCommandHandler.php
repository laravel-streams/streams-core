<?php namespace Streams\Platform\Ui\Form\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildFormActionsHandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();
    }
}
 