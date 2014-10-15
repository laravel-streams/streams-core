<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildTablePaginationHandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();

        $pagination = ['links' => 'LINKS'];

        return compact('pagination');
    }
}
 