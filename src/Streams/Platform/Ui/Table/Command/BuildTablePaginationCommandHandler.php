<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTablePaginationCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();

        $pagination = ['links' => 'LINKS'];

        return compact('pagination');
    }
}
 