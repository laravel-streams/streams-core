<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildTableOptionsHandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();

        $paginate = evaluate($ui->getPaginate(), [$ui]);

        return compact('paginate');
    }
}
 