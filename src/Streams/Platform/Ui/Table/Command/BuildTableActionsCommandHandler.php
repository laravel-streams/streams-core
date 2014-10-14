<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableActionsCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();
    }
}
 