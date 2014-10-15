<?php namespace Streams\Platform\Ui\Form\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildFormSectionsHandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();
    }
}
 