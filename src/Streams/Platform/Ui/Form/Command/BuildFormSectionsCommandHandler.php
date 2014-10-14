<?php namespace Streams\Platform\Ui\Form\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildFormSectionsCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();
    }
}
 